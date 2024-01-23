<?php
// 4-4から流用（コピー）し，ファイル名をmain.phpからindex.phpに変更
require_once('./util/session_check.php');

$message = $_SESSION['id']."さん、こんにちは！";
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>10-2 ログイン：ログイン後のページ | ノリと勢いで学ぶPHP</title>
</head>
<body>
    <h1>ログイン後の画面です！</h1>
    <p><?= $message ?></p>
    <!-- 元のページに戻す時はリンクを踏む -->
    <a href="./logout.php">ログアウト</a>
</body>
</html>