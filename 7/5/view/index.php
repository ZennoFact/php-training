<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>7-5 クラス | ノリと勢いで学ぶPHP実習</title>
</head>
<body>
    <h1><?= $title ?></h1>
    <div>
        <!-- では出力してみましょう -->
        <?php foreach($posts as $post): ?>
            <p><img src="<?= $post->getIconPath() ?>" alt="icon"><?= $post->show() ?></p>
        <?php endforeach; ?>
    </div>
</body>
</html>