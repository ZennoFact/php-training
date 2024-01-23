<?php
// DBに接続して情報を取り出すようにします。
require_once('./util/session_check.php');
require_once('./util/database.php');

$db = new Database("../sample.db");
// 現在ログイン中のユーザーデータを取得します。
$user = $db->getUser($_SESSION['id']);
$db->disconnect();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>10-4 ログイン：ログイン後のページ | ノリと勢いで学ぶPHP</title>
</head>
<body>
    <!-- 必要な情報を表示 -->
    <h1><?= $user['name'] ?> <span>@<?= $user['id'] ?></span></h1>
    <p>ログイン後の画面です。</p>
    <!-- 元のページに戻す時はリンクを踏む -->
    <a href="./logout.php">ログアウト</a>
</body>
</html>