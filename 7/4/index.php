<?php
require_once("./util/post.php");

// 引数を増やしたので修正。本来はデータベースから取得するので，こんなに手書きで書くことはしないです。
$posts = [
    new Post("ぜんのー先生", "zenno.jpg", "授業資料作ってるとPHPがより楽しくなってきた。", "2020-05-20 12:00:00"),
    new Post("ぜんのー先生", "zenno.jpg", "やっぱりお腹がすきました。", (new DateTime())->modify('-15 day')->format('Y-m-d H:i:s')), // 引き算もできる
    new Post("ぜんのー先生", "zenno.jpg", "PHPのdatetimeのフォーマット，24時間表記はHです。", (new DateTime())->format('Y-m-d H:i:s')),
];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>7-4 クラス | ノリと勢いで学ぶPHP実習</title>
</head>
<body>
    <h1>えっくす</h1>
    <div>
        <!-- では出力してみましょう -->
        <?php foreach($posts as $post): ?>
            <p><img src="<?= $post->getIconPath() ?>" alt="icon"><?= $post->show() ?></p>
        <?php endforeach; ?>
    </div>
</body>
</html>