<?php
// messageが送られてきていたら？(今回はmessageが空文字列だと誤送信という前提でシステムを作ります。)
if(isset($_POST['message']) && $_POST['message'] !== '') {
    // 今回は追記モードで開きます。追記モードはファイルポインタは終端に来ます（要するにファイルの最後に書き込まれます）
    $handle = fopen('./log/message.csv', 'a'); 
    // ファイルに書き込みます（最後に改行もつけてます）
    fwrite($handle, "{$_POST['name']},{$_POST['message']}\n");
    // ファイルを閉じます
    fclose($handle);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5-2 サーバ上のファイルへアクセス | ノリと勢いで学ぶPHP実習</title>
</head>
<body>
    <h1>ファイルの書き込み</h1>
    <form action="." method="post">
        <label for="name">名前</label><input id="name" type="text" name="name"><br>
        <label for="message">メッセージ</label><input id="message" type="text" name="message"><br>
        <input type="submit" value="送信">
    </form>
</body>
</html>