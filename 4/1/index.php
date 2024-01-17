<?php
// HTMLはページをまたぐときに情報を保持しないのが基本です。
// ページ間をまたいでデータを送るということは機能としてありますが，
// 基本的にステートレス（状態を持たない）という考え方があります。
// ただ，その考えで行くと，ログインして何かをするのは難しいですよね。
// そこで出てくるのが，cookieとsessionです。
// ざっくり，cookieはブラウザ側の仕組みでsessionはサーバ側の仕組みですが，
// 今回はsessionを使って簡易的なログインっぽいものを作ってみます。

// 以下は2-4のコードをベースにごく一部を変更しています。
// もう一つのmain.phpというファイルを作って，そこにログイン後のページを作り,接続します。
// まずは，セッションがない状況での接続です。

$correctID = "nori";
$correctPassword = "ikioi";

$message = "";
if( isset($_POST['id']) && isset($_POST['pw']) ) {
    if( $_POST['id'] == $correctID && $_POST['pw'] == $correctPassword ) {
        // 変更箇所はここ。header関数を使い，リダイレクトという機能で，main.phpに飛ばします。
        // header関数は，HTTPヘッダを送信する関数です。引数は文字列で，リダイレクト先のURLを"Location: URL"という形式で指定します。
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
    <title>4-1 ページをまたいだ利用 | ノリと勢いで学ぶPHP</title>
</head>
<body>
    <h1>SESSION無しの処理</h1>
    <form action="." method="post">
        <label for="id">ID</label><input id="id" type="text" name="id"><br>
        <label for="pw">パスワード</label><input id="pw" type="password" name="pw"><br>
        <input type="submit" value="ログイン">
    </form>
    <!-- 結果をメッセージとして出力しましょう -->
    <p><?php echo $message; ?></p>
</body>
</html>