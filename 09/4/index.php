<?php
// データの削除を考えます
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

    echo "削除<br>";

    // 変数じゃないとbind～ができない
    $userid = 'you';

    $sql = 'delete from user where userid = :userid';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userid', $userid);
    $stmt->execute();
    // 基本的に主キーなどで特定して削除することが多いが，
    // はたして，データベースからデータを削除することは良いのでしょうか
    // ユーザーが退会したら，退会したユーザーの情報は削除するのが正しいのでしょうか？
    // 是非友達と議論してみてください。
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