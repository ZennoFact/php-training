<?php
// データの変更です。
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

    echo "更新<br>";

    // ユーザーの入力などはよからぬデータを差し込まれる可能性があるため，
    // prepareで事前に準備しておくことはセキュリティの向上にも繋がります。

    // 後から入れたいデータの部分を「?」で表現することも可能です
    $sql = 'update user set name = ? where userid = ?';
    // prepareでsqlを実行する準備をします。
    $stmt = $pdo->prepare($sql);
    // 「?」で指定されている場合は，?の順に値を指定します。（位置大事）
    $stmt->execute(['うぬ', 'you']);
    
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