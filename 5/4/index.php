<?php
// ちょっとアレンジ
if(isset($_POST['message']) && $_POST['message'] !== '') {
    $handle = fopen('./log/message.csv', 'a'); 
    fwrite($handle, "{$_POST['name']},{$_POST['message']}\n");
    fclose($handle);
}

$messages = [];
if(file_exists('./log/message.csv')) {
    $handle = fopen('./log/message.csv', 'r');
    while($message = fgetcsv($handle)) {
        // 連想配列にしておくと，後々の記載が読みやすくなります。
        $messages[] = array(
            'from' => $message[0],
            'body' => $message[1]
        );
    }
    fclose($handle);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5-3 サーバ上のファイルへアクセス | ノリと勢いで学ぶPHP実習</title>
</head>
<body>
    <h1>ファイルの読み込み</h1>
    <form action="." method="post">
        <label for="name">名前</label><input id="name" type="text" name="name"><br>
        <label for="message">メッセージ</label><input id="message" type="text" name="message"><br>
        <input type="submit" value="送信">
    </form>
    <!-- メッセージの出力はこちら -->
    <?php foreach($messages as $message): ?>
        <p><?= $message['from'] ?>さん：<?= $message['body'] ?></p>
    <?php endforeach; ?>
</body>
</html>