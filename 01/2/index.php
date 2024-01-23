<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1-2 PHPの書き方2 | ノリと勢いで学ぶPHP実習</title>
</head>
<body>
    <?php
    // 未完成のHTMLに文章を足して1つのWebページとして完成させる。
    // このように，クライアント（ブラウザ）に返すHTMLにデータを追加していく。
    echo "Hello World!"; // 文字列を出力する
    ?>
    <!-- 変数の値などをHTMLに足すだけなら，以下のように省略が可能 -->
    <?= "" ?> <!-- これは何も出力されない -->
    <?= "Hello PHP!" ?> <!-- これはHello PHP!と出力される -->
</body>
</html>



