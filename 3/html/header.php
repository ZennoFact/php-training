<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | ノリと勢いで学ぶPHP</title><!-- ただし，Titleはページごとに変わる = 変数の出番 -->
    <!-- 本来はCSSのリンクなんかも付けるよー -->
</head>
<body>
    <header>
        <h1><?= $title ?></h1>
    </header>
    <div class="content">
    <!-- headタグやheaderタグだけではなく，切り分けれるところは自分で決めていい -->