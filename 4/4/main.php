<?php
// 切り分けたセッションのチェックを読み込みます
require_once('./util/session_check.php');

$message = $_SESSION['id']."さん、こんにちは！";
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4-4 ページをまたいだ利用 | ノリと勢いで学ぶPHP</title>
</head>
<body>
    <h1>ログイン後の画面です！</h1>
    <p><?= $message ?></p>
    <!-- 元のページに戻す時はリンクを踏む -->
    <a href="./logout.php">ログアウト</a>
</body>
</html>