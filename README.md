# ①課題番号-プロダクト名

課題番号　9
G’s Learing system課題タイトル　卒制プロトタイプ
GitHubリポジトリ名　kadai09_PHP-SQL_CRUD

## ②課題内容（どんな作品か）

- 来店客数の予想分布と客単価の予想分布から、売上高の予想分布をモンテカルロ的にシミュレートして、グラフに出力させる。

## ③DEMO

デプロイしている場合はURLを記入（任意）

## ④作ったアプリケーション用のIDまたはPasswordがある場合

なし。
- ID: N/A
- PW: N/A

## ⑤工夫した点・こだわった点

- 「乱数」はデータ生成のためにまずは、モデルを作成しました。
【具体的には以下の通り】
　・来店客数の分布：平均350名　標準偏差50人の正規分布をしている
　・客単価の分布：平均750円　標準偏差300円の正規分布をしている
ただし、両方の値を共に、整数としてマイナスの値は除外する。
当該モデルにのっとった乱数をそれぞれ10000回発生させて、各数字を生成しそこから売上高を計算した。
そこから10,000円単位で件数カウントし、度数分布状況をヒストグラフで出力する。
集計までをPHP＋SQLで行い、ヒストグラフ出力をPythonにて実行した。

## ⑥難しかった点・次回トライしたいこと(又は機能)

- PHP上でグラフ化しようとしましたが、当該モジュールをインストールしなければならず、タイムオーバーでそこまで行けませんでした。次回チャレンジしたいです。

## ⑦質問・疑問・感想、シェアしたいこと等なんでも
特になし
- [質問]　N/A
- [感想]　N/A
- [参考記事]　N/A
  - 1. [URLをここに記入]　N/A
  - 2. [URLをここに記入]　N/A