<?php
$dbname = '../sample.db';
try {
    // PDOのインスタンスを作成するとDBとの接続が開始されます。
    $pdo = new PDO("sqlite:$dbname");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo '接続に成功しました。';

    // 存在していなければテーブルを作成します
    // pdoのqueryメソッドにSQL文を渡すことで実行できます。
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
    echo 'テーブルを作成しました。';

    // データを取得します：SQLは小文字でもOKです。
    // 今回は同じ処理を複数書くのがめんどくさかったので関数にしました。
    showAll($pdo);

    // データを挿入します
    echo "挿入<br>";
    $pdo->query("insert into user (userid, password, name, email) values ('zenno', 'nyaaa', 'ぜんのーさん', 'test@sample.domain')");


    // ちゃんと保存できたか確認します
    showAll($pdo);
    
    // nullを代入することで接続を切断します。
    $pdo = null;
} catch (Exception $e) {
    echo '処理に失敗しました。';
    echo $e->getMessage();
    exit;
}


function showAll($pdo) {
    // 今回はuseridとnameのみ取得します。（保存できていなければ出ません。）
    // queryメソッドにsqlを渡すと結果（PDOStatement）が返ってきます。
    $stmt = $pdo->query('select userid, name from user');
    // fetchAllメソッドを使うとPDOStatementの中身を配列で取得できます。
    // 引数のPDO::FETCH_ASSOCは連想配列で取得したい場合に指定します。
    // 連想配列にしておくと，カラム名で値を取得できて便利です。
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo 'show all<br>';
    foreach ($result as $row) {
        echo $row['userid'] . 'さんの名前は' . $row['name'] . 'です。<br>';
    }
}