<?php
// 8-1で設定したXAMPP環境でDBにアクセスできるか確認します。
// 
$dbname = '../sample.db';

// ファイルやデータベースなどに触れる場合は、try-catchで囲みます。
// プログラム外の要因で例外（ざっくり言うとエラー）が発生する可能性があるものに対して使います。
// 例えば、ファイルが存在しない、データベースに接続できない、などです。
// tryで囲った部分で例外が出ると catch で囲んだ部分が実行されます。
// 例外が出なければ catch は実行されません。
// また，処理としては「重たい」処理になるので，全コードを try-catch で囲むのは避けましょう。
try {
    // PHPにはPDO（PHP Data Objects）という便利機能がある
    // これを使うと，データベースの種類ごと対応したコードを書かなくても，
    // 同じコードでデータベースにアクセスできる

    // 今回はSQLiteを使うので，sqlite: という接続文字列を使う
    // データベース名は任意。今回は.dbという拡張子にしています。
    // 接続すべきテータベースがなければ，新しく作成されます。
    $pdo = new PDO("sqlite:$dbname");
    // エラーが発生した時にPDOExceptionという例外を投げるように設定します。
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo '接続に成功しました。';
} catch (Exception $e) {
    echo '接続に失敗しました。';
    echo $e->getMessage();
    exit;
}