<!-- めちゃくちゃ改良した -->

<?php require_once('./view/common/header.php'); ?>
<?php require_once('./view/common/menu.php'); ?>

<div class="main">
    <!-- 投稿の情報を一覧表示します -->
    <?php foreach($posts as $post): ?>
        <div class="post">
            <div class="post-header">
                <img class="user-icon" src="images/accounts/<?= $post->getUserId() ?>.jpg" alt="アイコン画像">
                <span class="user-id"><?= $post->getUserId() ?></span>
            </div>
            <div class="post-image">
                <img src="images/accounts/<?= $post->getUserId() ?>.jpg" alt="投稿画像">
            </div>
            <div class="icons">
                <!-- こういうところはほんとなら「アイコンフォント」を使いたいところ -->
                <span class="good"><a>♡</a></span>
                <span class="comment"><a>💬</a></span>
            </div>
            <?php if(!empty($post->getText())): ?>
            <div class="post-text">    
                <p><span class="user-id"><?= $post->getUserId() ?></span><span class="text"><?= $post->getText() ?></span></p>
            </div>
            <?php endif; ?>
            <?php if(!empty($post->getComments())): ?>
            <div class="comments">
                <?php foreach($post->getComments() as $comment): ?>
                <p><img class="user-icon" src="images/accounts/@no_image.png" alt="投稿画像"><span class="user-id">Who?</span><span class="text"><?= $comment ?></span></p>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div class="comment-input">
                <p class="annotation">コメントを追加...</p>
                <form action="./good.php" method="post">
                    <input type="text" name="comment">
                    <input type="submit" value="送信">
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once('./view/common/footer.php'); ?>