<?php
// クラスを書くときは大体別ファイルにしますので，require_onceなりで読み込みましょう。
require_once("post.php");

// クラスを使うときは，new演算子を使います。new演算子は，クラスのインスタンスを作成します。
$post = new Post();
// 今回のクラスはnameとtextというプロパティを持っていますので，それらに値を代入します。
// 代入するときは，アロー演算子を使います。
$post->name = "ぜんのー先生";
$post->text = "授業資料作ってるとPHPがより楽しくなってきた。";
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>7-1 クラス | ノリと勢いで学ぶPHP実習</title>
</head>
<body>
    <h1>えっくす</h1>
    <div>
        <!-- では出力してみましょう -->
        <p><?= $post->show() ?></p>
    </div>
</body>
</html>