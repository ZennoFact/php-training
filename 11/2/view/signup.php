<?php require_once('./view/common/header.php'); ?>

<div class="form">
    <h1>新規アカウント作成</h1>
    <p class="error-message"><?= $message; ?></p>
    <form enctype="multipart/form-data" action="./signup.php" method="post">
        <label for="id">ID</label><input id="id" type="text" name="id" value="<?= $id ?>" required><br>
        <label for="pw">パスワード</label><input id="pw" type="password" name="pw" value="<?= $pw ?>" required><br>
        <label for="name">表示名</label><input id="name" type="text" name="name" value="<?= $name ?>" required><br>
        <label for="email">メールアドレス</label><input id="email" type="text" name="email" value="<?= $email ?>" required><br>
        <input type="hidden" name="MAX_FILE_SIZE" value="400000">
        <input name="userfile" type="file" accept="image/png, image/jpeg"/>
        <p class="annotation">※画像は任意です，128px×128pxのサイズで用意してください。</p>
        <input type="submit" value="sign up">
    </form>
    <a href="./login.php">ログイン画面に戻る</a>
</div>

<?php require_once('./view/common/footer.php'); ?>

