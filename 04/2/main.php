<?php
// ログイン後のページでもセッションを開始しなければログイン前に設定したセッションデータが見えません。
session_start();

// 直接URLを入力された時の対策
if(!isset($_SESSION['id'])) {
    // ログインしていない場合はログインページに戻す
    header("Location: .");
    exit;
}

$message = $_SESSION['id']."さん、こんにちは！";
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>4-2 ページをまたいだ利用 | ノリと勢いで学ぶPHP</title>
</head>
<body>
    <h1>ログイン後の画面です！</h1>
    <p><?= $message ?></p>
    <!-- 元のページに戻す時はリンクを踏む -->
    <a href=".">ログアウト</a>
    <!-- ただし，リンクを踏んでもログイン・ログアウトの処理をしていない以上，
        http://localhost/php-training/4/1/main.php にアクセスしたらページが見えてしまう。 -->;
</body>
</html>