<?php
$dbname = '../sample.db';
try {
    $pdo = new PDO("sqlite:$dbname");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo '接続に成功しました。';

    $sql = <<<EOS
CREATE TABLE IF NOT EXISTS user (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    userid TEXT,
    password TEXT,
    name TEXT,
    email TEXT
)
EOS;
    $pdo->query($sql);
    showAll($pdo);

    // IDがzennoのユーザーの名前を変更します
    echo "変更<br>";
    $pdo->query("update user set name = 'ぜんのー先生' where userid = 'zenno'");

    showAll($pdo);
    
    $pdo = null;
} catch (Exception $e) {
    echo '処理に失敗しました。';
    echo $e->getMessage();
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