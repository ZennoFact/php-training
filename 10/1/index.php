<?php
// ログインに必要そうな処理をクラスにまとめてみます。
require_once('database.php');

$db = new Database('../sample.db');

// 動作確認にいろいろ試してみましょう
// var_dump($db->getUser('zenno'));
// echo $db->updateUser('zenno', 'ぜんのー先生', 'test001@sample.admin');
// echo $db->disableUser('hedgehog');
// echo $db -> insertUser('seica', 'test4', 'seica', 'test4@sample.admin');
$users = $db->getActiveUsers();

$db->disconnect();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>データベースクラスの実験</h1>
    <p>有効なユーザー一覧</p>
    <ul>
    <?php foreach ($users as $user) : ?>
        <li><?= $user['name'] ?>:<?= $user['email'] ?></li>
    <?php endforeach; ?>
    </ul>
</body>
</html>