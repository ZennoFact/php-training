<?php
session_start();

if(isset($_SESSION['id'])) {
    header("Location: .");
    exit;
}

$id = isset($_POST['id']) ? $_POST['id'] : "";
$pw = isset($_POST['pw']) ? $_POST['pw'] : "";
$name = isset($_POST['name']) ? $_POST['name'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$message = "";

if( isset($_POST['id']) && isset($_POST['pw']) && isset($_POST['name']) && isset($_POST['email']) ) {
    require_once('./util/database.php');
    $db = new Database("../sample.db");

    // 画像ファイルがあれば取得
    $file = isset($_FILES['userfile']) ? $_FILES['userfile'] : null;
    $result =  $db->sighUpProcess($_POST['id'], $_POST['pw'], $_POST['name'], $_POST['email'], $file);
    $db->disconnect();
    
    if( $result['isSuccess'] ) {


        header("Location: ./login.php?message={$result['message']}");
    } else {
        $message = $result['message'];
    }
} else if(isset($_GET)) {
    $message = "登録に必要な情報は全て入力してください。";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>11-1 新規アカウント作成 | ノリと勢いで学ぶPHP</title>
</head>
<body>
    <h1>新規アカウント作成</h1>
    <form enctype="multipart/form-data" action="./signup.php" method="post">
        <label for="id">ID</label><input id="id" type="text" name="id" value="<?= $id ?>" required><br>
        <label for="pw">パスワード</label><input id="pw" type="password" name="pw" value="<?= $pw ?>" required><br>
        <label for="name">表示名</label><input id="name" type="text" name="name" value="<?= $name ?>" required><br>
        <label for="email">メールアドレス</label><input id="email" type="text" name="email" value="<?= $email ?>" required><br>
        <input type="hidden" name="MAX_FILE_SIZE" value="400000">
        <input name="userfile" type="file" accept="image/png, image/jpeg"/>
        <p>※画像は任意です，128px×128pxのサイズで用意してください。</p>
        <input type="submit" value="sign up">
    </form>
    <p><?php echo $message; ?></p>
    <a href="./login.php">ログイン画面に戻る</a>
</body>
</html>