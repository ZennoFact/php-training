<?php
require_once("post.php");

// ポストは配列で取ることにしました。[]で省略して書けることを今思い出しました。
// 現在（今この時）を取得するには，new DateTime()とすることで取得できます。
$posts = [
    new Post("ぜんのー先生", "授業資料作ってるとPHPがより楽しくなってきた。", "2020-05-20 12:00:00"),
    new Post("ぜんのー先生", "やっぱりお腹がすきました。", (new DateTime())->modify('-15 day')->format('Y-m-d H:i:s')), // 引き算もできる
    new Post("ぜんのー先生", "PHPのdatetimeのフォーマット，24時間表記はHです。", (new DateTime())->format('Y-m-d H:i:s')),
];
// ポストのデータを追記したり書き換えたりして遊んでみてください。
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
            <p><?= $post->show() ?></p>
        <?php endforeach; ?>
    </div>
</body>
</html>