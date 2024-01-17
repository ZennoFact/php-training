<?php
// POSTの場合はURLにデータが乗りません。なので，ログリンなどの処理（外に漏れちゃいけない情報を送るとき）はPOSTで送信します。
// 受け取り方はGETとそっくりで，$_POST['キー'] です。

// 今回はサンプルとして正しいIDとPWをPHP上で設定しますが，本来はデータベースなどに保存しておくのが一般的です。
$correctID = "nori";
$correctPassword = "ikioi";

// まずは$_POSTにデータが入っているか確認します(GETと同じですね)
$message = "";
if( isset($_POST['id']) && isset($_POST['pw']) ) {
    if( $_POST['id'] == $correctID && $_POST['pw'] == $correctPassword ) {
        $message = "ログイン成功！";
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
    <title>2-4 ページをまたいだデータの移動 | ノリと勢いで学ぶPHP</title>
</head>
<body>
    <h1>POSTの練習</h1>
    <form action="." method="post">
        <label for="id">ID</label><input id="id" type="text" name="id"><br>
        <label for="pw">パスワード</label><input id="pw" type="password" name="pw"><br>
        <input type="submit" value="ログイン">
    </form>
    <!-- 結果をメッセージとして出力しましょう -->
    <p><?php echo $message; ?></p>
</body>
</html>