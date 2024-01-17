<?php
// PHPは分割して書くことができる
// 個人的には準備できるだけ準備してから出力する方が好き
// 変数は$を付けるルールになっている
$word1 = 'Hello World!';
$word2 = '<h1>Hello PHP!</h1>';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1-3 PHPの書き方 | ノリと勢いで学ぶPHP実習</title>
</head>
<body>
    <!-- 以下の2つはどちらもh1タグを表現することになる。 -->
    <!-- 私はHTMLはHTMLで，データはPHPでと分けたいので，上の書き方の方が好き -->
    <h1><?= $word1 ?></h1>
    <?= $word2 ?>
</body>
</html>

