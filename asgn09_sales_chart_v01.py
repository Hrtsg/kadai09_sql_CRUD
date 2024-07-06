import os
import mysql.connector
import pymysql
import pandas as pd
import japanize_matplotlib
import matplotlib.pyplot as plt

# host = 'localhost'
# port = '3306'
# user = 'root'
# password = ''
# database = 'gs_asgn08_db'

if __name__ == '__main__':

    cnx = mysql.connector.connect(
        user='root',
        host='127.0.0.1',
        port = '3306',
        password='',# ダブルクォートで囲っては駄目
        database='gs_asgn08_db'
)

# カーソルを取得する
cur = cnx.cursor()

# データを取得
cur.execute('SELECT * FROM sales_dosu')
rows = cur.fetchall()

# データをデータフレームに変換
df = pd.DataFrame(rows, columns=['id', 'band_of_sales', 'Dosu'])

# データを表示
print(df)

# グラフを作成
df.plot(kind='bar', x='band_of_sales', y='Dosu')
plt.show()

cur.close()
cnx.close()