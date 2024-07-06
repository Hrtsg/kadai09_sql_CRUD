<?php
//1.  DB接続します
include('functions.php');
$pdo = connect_to_db();

//２．データ登録SQL作成
$sql = "SELECT * FROM sample_sales";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute(); //true or falseが入る

//３．データ表示
// $view="";　無視
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//JSONい値を渡す場合に使う
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>


<!DOCTYPE html>
<html lang="ja">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>売上分布一覧</title>
      <script src="https://d3js.org/d3.v7.min.js"></script>
      <link rel="stylesheet" href="css/range.css">
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <style>
        div{padding: 10px;font-size:16px;}
        td{border: 1px solid red;}
      </style>
    </head>
  <body id="main">
    <!-- Head[Start] -->
    <header>
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
          <a class="navbar-brand" href="asgn08.php">データ表示</a>
          </div>
        </div>
      </nav>
    </header>
    <!-- Head[End] -->
    <!-- Main[Start] -->
    <div>
        <!-- <div class="container jumbotron"></div> -->
        <div class="table_all"></div>
        <table>
          <?php 
          echo "上から5行目までを出力 ID/客数/客単価/売上:\n";
          $first_five_values = array_slice($values, 0, 5);
          foreach($first_five_values as $value){ ?>
            <tr>
              <td><?=$value["ID"]?></td>
              <td><?=$value["customer"]?></td>
              <td><?=$value["sales_per_cust"]?></td>
              <td><?=$value["sales"]?></td>
            </tr>
              <?php } ?>
          </table>
    </div>
    <div class="table_kubun">
      <?php 
        // データ区分（例：10000区切り）ごとにカウントするための配列を初期化
        $count_by_segment = [];
        // データを10000区切りでカウントする
        foreach($values as $value){
          // 区分を計算（例：1〜10000, 10001〜20000, ...）
        // var_dump($value["sales"]);
          $segment = ceil($value["sales"] / 10000);
        // var_dump($segment);
          // 区分ごとにカウントを増やす
          if (!isset($count_by_segment[$segment])) {
            $count_by_segment[$segment] = 0;
          }
          $count_by_segment[$segment]++;
        }?>
      <table>
        <?php
        // 区分ごとのカウント結果を昇順でソートする
        ksort($count_by_segment);
        // 結果を出力する
        echo "各区切りごとのカウント結果:\n";
        foreach ($count_by_segment as $segment => $count) {
          $start = ($segment - 1) * 10000 + 1;
          $end = $segment * 10000;

          $sql = 'INSERT INTO sales_dosu(id, band_of_sales,Dosu) VALUES(NULL, :band_of_sales, :Dosu)';

          $stmt = $pdo->prepare($sql);
          $stmt->bindValue(':band_of_sales', $end, PDO::PARAM_INT);
          $stmt->bindValue(':Dosu', $count, PDO::PARAM_INT);
          try {
            $status = $stmt->execute();
          } catch (PDOException $e) {
            echo json_encode(["sql error" => "{$e->getMessage()}"]);
            exit();
          }
          ?>
          <tr>
          <td><?=$end?></td>
          <td><?=$count?></td>
          </tr>
          <!-- echo "区切り {$start} 〜 {$end}: {$count} 個\n"; -->
        <?php
        }?>
      </table>
    </div>
    <!-- Main[End] -->
  </body>
</html>