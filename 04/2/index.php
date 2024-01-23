<?php
// セッションを開始するには先頭でsession_start()を実行します
session_start();

$correctID = "nori";
$correctPassword = "ikioi";

$message = "";
if( isset($_POST['id']) && isset($_POST['pw']) ) {
    if( $_POST['id'] == $correctID && $_POST['pw'] == $correctPassword ) {
        // ログインに成功したらsessionを維持するためのIDを再発行します
        session_regenerate_id(true);
        // 今回は，リダイレクト前にログインした人のIDを$_sessionに保存しておきます
        $_SESSION['id'] = $_POST['id'];

        header("Location: main.php");
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
    <title>4-2 ページをまたいだ利用 | ノリと勢いで学ぶPHP</title>
</head>
<body>
    <h1>SESSION有りの処理</h1>
    <form action="." method="post">
        <label for="id">ID</label><input id="id" type="text" name="id"><br>
        <label for="pw">パスワード</label><input id="pw" type="password" name="pw"><br>
        <input type="submit" value="ログイン">
    </form>
    <!-- 結果をメッセージとして出力しましょう -->
    <p><?php echo $message; ?></p>
</body>
</html>