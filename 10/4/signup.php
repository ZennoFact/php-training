<?php
session_start();

if(isset($_SESSION['id'])) {
    header("Location: .");
    exit;
}

// 三項演算子の例です。
// 「条件式 ? trueの時の値 : falseの時の値」という書き方です。
$id = isset($_POST['id']) ? $_POST['id'] : "";
$pw = isset($_POST['pw']) ? $_POST['pw'] : "";
$name = isset($_POST['name']) ? $_POST['name'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$message = "";
// 必要な情報がすべてそろっていれば，登録処理に進みます。
if( isset($_POST['id']) && isset($_POST['pw']) && isset($_POST['name']) && isset($_POST['email']) ) {
    require_once('./util/database.php');
    $db = new Database("../sample.db");

    // 個人的にはここで比較をするよりはDB側で比較した方が良いと思っています。
    // なので，Databaseクラスと共にちょっと修正しましょう
    $result =  $db->sighUpProcess($_POST['id'], $_POST['pw'], $_POST['name'], $_POST['email']);
    $db->disconnect();

    if( $result['isSuccess'] ) {
        // 登録完了メッセージと共に，ログイン画面に戻ります。
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
    <title>10-4 新規アカウント作成 | ノリと勢いで学ぶPHP</title>
</head>
<body>
    <h1>新規アカウント作成</h1>
    <form action="./signup.php" method="post">
        <!-- 新規登録ができなかった際に，再入力の手間を減らすことができるようにフォームを作成します -->
        <!-- また，入力項目は必須項目に設定します(requiredを設定) -->
        <label for="id">ID</label><input id="id" type="text" name="id" value="<?= $id ?>" required><br>
        <label for="pw">パスワード</label><input id="pw" type="password" name="pw" value="<?= $pw ?>" required><br>
        <label for="name">表示名</label><input id="name" type="text" name="name" value="<?= $name ?>" required><br>
        <label for="email">メールアドレス</label><input id="email" type="text" name="email" value="<?= $email ?>" required><br>
        <input type="submit" value="sign up">
    </form>
    <p><?php echo $message; ?></p>
    <a href="./login.php">ログイン画面に戻る</a>
</body>
</html>