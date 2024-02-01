<?php require_once('./view/common/header.php'); ?>
<?php require_once('./view/common/menu.php'); ?>

<div class="main">
    <h1><img src="image.php?v=<?= $user['id'] ?>" alt="アイコン画像"><?= $user['name'] ?> <span>@<?= $user['id'] ?></span></h1>
    <p>ログイン後の画面です。</p>
    <a href="./logout.php">ログアウト</a>
</div>

<?php require_once('./view/common/footer.php'); ?>