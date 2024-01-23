# SQLite3について
(ここ)[https://www.sqlite.org/index.html]から確認を。  
データをためて効率よく取り出すのがデータベースの仕組みです。
CSVファイルを使って管理すると，データを使いたければ全件取り出してプログラム内で抽出して使うことになりますが，データベースならそもそも抽出したデータを使えるのが嬉しいですよね。分かれたテーブルの情報を結合して使うなこともできるので便利極まりないです。  
sqliteの良さはインストールせずに使えることなので，学校の公開領域などデータベース管理システムがインストールされていない環境にも持ち込めるので嬉しい。  
あと，Windows版のPHPにはそもそも最初から含まれているはず。なので下記XAMPPでの使い方にあるように使いやすい。  
※Web系の仕事ではMySQLとか使うことの方が圧倒的に多いと思うので，SQLite3で慣れたらぜひMySQLなども触ってみてください。

## XAMPPでの使い方
- XAMPP Control Panel のApache： Config ->  PHP(php.ini)を選択
- Windowsなら「;sqlite3.extension_dir =」を「sqlite3.extension_dir = "C:\xampp\php\ext"」に変更（インストール時にデフォルト設定から動かしていない場合）
- ";extension=sqlite3" とsqlite3がコメントアウトされていたら，";"を消して有効化（"extension=sqlite3"）する
- 動かしていたらapacheは再起動する

## もし，手元の環境にsqlite3がない，or コマンドラインで使いたい場合は(ダウンロード)[https://www.sqlite.org/download.html]が必要
- Precompiled Binaries for ～ でOS指定して選択（学校の公開サーバにあげる際もこっち）
- Windowsでdllだけほしい（PHPからしか動かさない）なら，sqlite-dll-win-x8-6～ から何bitマシンか選択して実施
