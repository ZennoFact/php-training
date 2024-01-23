<?php
// 4-4から流用（コピー）し，ファイル名をinde.phpからlogin.phpに変更
session_start();

if(isset($_SESSION['id'])) {
    // リダイレクト先を修正
    header("Location: .");
    exit;
}

$message = "";
if( isset($_POST['id']) && isset($_POST['pw']) ) {
    // データが飛んで来たらデータベースへの接続開始
    require_once('./util/database.php');
    $db = new Database("../sample.db");

    // データベースにユーザがいるかを問い合わせる
    $user =  $db->getUser($_POST['id']);
    $db->disconnect();
    
    // 検索した結果falseではない，かつ，パスワードが正しい場合はログインという形に修正
    if( $user && $_POST['pw'] == $user['password'] ) {
        session_regenerate_id(true);
        $_SESSION['id'] = $_POST['id'];
        // リダイレクト先を修正
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
    <title>10-2 ログイン：ログイン画面 | ノリと勢いで学ぶPHP</title>
</head>
<body>
    <h1>ログイン</h1>
    <!-- login.phpに情報を飛ばして判定をします -->
    <form action="./login.php" method="post">
        <label for="id">ID</label><input id="id" type="text" name="id"><br>
        <label for="pw">パスワード</label><input id="pw" type="password" name="pw"><br>
        <input type="submit" value="ログイン">
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>