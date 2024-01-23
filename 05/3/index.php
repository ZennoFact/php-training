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

$messages = [];
// ファイルの読み込みは，対象のファイルが存在していないとエラーになるので存在チェックを行います。
if(file_exists('./log/message.csv')) {
    // ファイルを開きます
    $handle = fopen('./log/message.csv', 'r');
    // ファイルの中身を読み込みこんで配列に格納します
    // while($message = fgets($handle)) {
    //     // csvファイルはカンマ区切りなので，explode関数で配列に変換します
    //     $messages[] = explode(',', $message);
    // }

    // CSVファイルならfgetcsvの方が楽（1行を読み取って，フィールド（列の項目）を配列として格納してくれます）
    while($message = fgetcsv($handle)) {
        $messages[] = $message;
    }
    // ファイルを閉じます
    fclose($handle);

    // ファイル内のデータの削除は結構めんどくさいのでデータベースまでお預け。
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
        <p><?= $message[0] ?>さん：<?= $message[1] ?></p>
    <?php endforeach; ?>
</body>
</html>