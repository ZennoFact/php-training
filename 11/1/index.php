<?php
require_once('./util/session_check.php');
require_once('./util/database.php');

$db = new Database("../sample.db");
$user = $db->getUser($_SESSION['id']);
$db->disconnect();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>11-1 ログイン：ログイン後のページ | ノリと勢いで学ぶPHP</title>
</head>
<body>
    <h1><img src="image.php?v=<?= $user['id'] ?>" alt="アイコン画像"><?= $user['name'] ?> <span>@<?= $user['id'] ?></span></h1>
    <p>ログイン後の画面です。</p>
    <a href="./logout.php">ログアウト</a>
</body>
</html>