<?php
// データベースは8で作成したsample.dbをコピーして使用します
// コードも8-3から流用しています。
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

    // PDOでは本来,sqlを実行する際に準備（prepare）して
    // データを結び付けて（bind）実行（execute）するものですが、
    // データの結び付けがないシンプルなSQL文の場合はqueryメソッドで
    // 準備から実行まで，一気に実行することができます。
    // 便利ではあるのですが，ユーザーの操作を反映したsqlの発行には不向きです。
    // また，毎回準備から行うため，複数回発行する場合は8-2で行うやり方の方が効率が良いです。
    echo "挿入<br>";
    $pdo->query("insert into user (userid, password, name, email) values ('zenno', 'nyaaa', 'ぜんのー先生', 'test@sample.domain')");
    $pdo->query("insert into user (userid, password, name, email) values ('you', 'waaa', 'あなた', 'you@sample.domain')");
    $pdo->query("insert into user (userid, password, name, email) values ('hedgehog', 'gyaaa', 'ハリネズミ', 'hh@sample.domain')");

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