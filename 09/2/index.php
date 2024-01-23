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

    // 今回は事前に登録したいデータを配列にしておきます
    $users = [
        ['userid' => 'zenno', 'password' => 'nyaaa', 'name' => 'ぜんのー先生', 'email' => 'test@sample.domain',],
        ['userid' => 'you', 'password' => 'waaa', 'name' => 'あなた', 'email' => 'you@sample.domain',],
        ['userid' => 'hedgehog', 'password' => 'gyaaa', 'name' => 'ハリネズミ', 'email' => 'hh@sample.domain',],
    ];
 
    echo "挿入<br>";

    // prepare -> bind -> executeの流れでsqlを実行します。
    // まずは後から入れたい値の部分を「:カラム名」としてsqlを作成します。
    // この時点では値は入っていません。
    $sql = 'insert into user (userid, password, name, email) values (:userid, :password, :name, :email)';
    // prepareでsqlを実行する準備をします。
    $stmt = $pdo->prepare($sql);
    // 実行前にbind〇〇で値を入れます。数値ならbindValue、文字列ならbindParamを使います。
    // ここで指定した値が上の:カラム名の部分に入ります。
  
    // 今回は配列の中身を一つずつ取り出して登録していきます。
    foreach($users as $user) {
        // $stmt->bindValue(':userid', $user['userid'], PDO::PARAM_STR);
        // $stmt->bindValue(':password', $user['password'], PDO::PARAM_STR);
        // $stmt->bindValue(':name', $user['name'], PDO::PARAM_STR);
        // $stmt->bindValue(':email', $user['email'], PDO::PARAM_STR);
        // // セットが完了したら毎回実行します。
        // $stmt->execute();

        // // executeに連想配列を指定して，一気に実行することも可能です。
        // $stmt->execute([
        //     ':userid' => $user['userid'],
        //     ':password' => $user['password'],
        //     ':name' => $user['name'],
        //     ':email' => $user['email'],
        // ]);

        // 今回は元データ自体をそのまま引数に渡しても動きます（配列のキーがカラム名と一致しているため）
        $stmt->execute($user);
    }
    
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