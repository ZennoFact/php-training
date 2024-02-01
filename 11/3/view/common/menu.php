<!-- menu -->
<div class="menu">
    <!-- menuのような文字の少ないリストを表現します -->
    <menu>
        <!-- TODO: ロゴ，のっける？ -->
        <li><a href="./index.php">ホーム</a></li>
        <li><a href="./search.php">検索</a></li>
        <li><a href="./login.php">投稿</a></li>
        <li><a href="./profile.php"><img src="image.php?v=<?= $user['id'] ?>" alt="アイコン画像"><span>プロフィール</span></a></li>
        <!-- TODO: ログアウトは少し押しにくいように調整 -->
        <li><a href="./logout.php">ログアウト</a></li>
    </menu>
</div>