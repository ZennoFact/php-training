<?php
// データの追加もやることは基本的に一緒です。
$dbname = '../sample.db';
try {
    $pdo = new PDO("sqlite:$dbname");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo '接続に成功しました。';

    // コマンドラインから直接DBを操作してテーブルを作成してからプログラムを動かすことももちろん可能です。
    // その場合は毎回このSQLを発行せずに済みますね。というわけで，今回は事前に作っているということで，このSQLはコメントアウトしておきます。
//     $sql = <<<EOS
// CREATE TABLE IF NOT EXISTS user (
//     id INTEGER PRIMARY KEY AUTOINCREMENT,
//     userid TEXT,
//     password TEXT,
//     name TEXT,
//     email TEXT
// )
// EOS;
    echo "削除<br>";

    // データベースは複数の処理を連続で行うことができます。
    // 今回の例ではuserテーブルからuseridがyouのデータを削除しています。
    // が，複数のテーブルがあった場合，一つの変更が他のテーブルに影響を与えることがあります。
    // その際に，ちゃんと正常に作動するときのみ実施したいと考えるますよね。
    // そのような場合には，トランザクションという機能を使います。
    // トランザクションは，複数の処理を一つのまとまりとして扱う機能です。
    // トランザクションを開始するときには，$pdo->beginTransaction();を実行します。
    // トランザクションの中で実行された処理は，$pdo->commit();を実行するまで実際には実行されません。
    // トランザクションの中でエラーが発生した場合には，$pdo->rollBack();を実行することで，
    // トランザクションの中で実行された処理をすべて取り消すことができます。
    // 以下のサンプルを確認してください。

    // トランザクションの開始
    $pdo->beginTransaction();

    $userid = 'you';
    $sql = 'delete from user where userid = :userid';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userid', $userid);
    $stmt->execute();

    // その後，複数のデータベース操作を実行したとしてください。

    // トランザクションの終了（すべての処理を確定）
    $pdo->commit();
    $pdo = null;

    echo '削除しました。<br>';
} catch (Exception $e) {
    echo '処理に失敗しました。';
    echo $e->getMessage();

    // トランザクションの中でエラーが発生した場合には，例外処理でここへ。
    // $pdo->rollBack();　を実行して，トランザクションの中で実行された処理をすべて取り消します。
    $pdo->rollBack();
    exit;
}


function showAll($pdo) {
    $stmt = $pdo->query('select userid, name from user');
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo 'show all<br>';
    foreach ($result as $row) {
        echo $row['userid'] . 'さんの名前は' . $row['name'] . 'です。<br>';
    }
}