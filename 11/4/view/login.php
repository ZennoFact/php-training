<?php require_once('./view/common/header.php'); ?>

<div class="form">
    <h1>ログイン</h1>
    <p class="error-message"><?= $message ?></p>
    <form action="./login.php" method="post">
        <input id="id" type="text" name="id" placeholder="ユーザーID"><br>
        <input id="pw" type="password" name="pw" placeholder="パスワード"><br>
        <input type="submit" value="ログイン">
    </form>
    <a class="goto-signup" href="./signup.php">新規アカウント作成</a>
</div>

<?php require_once('./view/common/footer.php'); ?>