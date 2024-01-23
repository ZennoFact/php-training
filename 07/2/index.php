<?php
require_once("post.php");

// コンストラクタの力でインスタンスの作成と共にプロパティの初期化もします。
// とても便利！
$post1 = new Post("ぜんのー先生", "授業資料作ってるとPHPがより楽しくなってきた。");
$post2 = new Post("ぜんのー先生", "だがお腹が空いた。");
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>7-2 クラス | ノリと勢いで学ぶPHP実習</title>
</head>
<body>
    <h1>えっくす</h1>
    <div>
        <!-- では出力してみましょう -->
        <p><?= $post1->show() ?></p>
        <p><?= $post2->show() ?></p>
    </div>
</body>
</html>