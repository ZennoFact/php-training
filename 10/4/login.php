<?php
session_start();

if(isset($_SESSION['id'])) {
    header("Location: .");
    exit;
}

// 三項演算子の例です。
// 「条件式 ? trueの時の値 : falseの時の値」という書き方です。
$message = isset($_GET['message']) ? $_GET['message'] : ""; 

if( isset($_POST['id']) && isset($_POST['pw']) ) {

    require_once('./util/database.php');
    $db = new Database("../sample.db");

    // 個人的にはここで比較をするよりはDB側で比較した方が良いと思っています。
    // なので，Databaseクラスと共にちょっと修正しましょう
    $userId =  $db->loginProcess($_POST['id'], $_POST['pw']);
    $db->disconnect();

    if( $userId ) {
        session_regenerate_id(true);
        $_SESSION['id'] = $userId;
        
        header("Location: .");
    } else {
        $message = "IDかパスワードが間違っています。";
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>10-4 ログイン：ログイン画面 | ノリと勢いで学ぶPHP</title>
</head>
<body>
    <h1>ログイン</h1>
    <p><?= $message ?></p>
    <form action="./login.php" method="post">
        <label for="id">ID</label><input id="id" type="text" name="id"><br>
        <label for="pw">パスワード</label><input id="pw" type="password" name="pw"><br>
        <input type="submit" value="ログイン">
    </form>
    <a href="./signup.php">新規アカウント作成</a>
</body>
</html>