<?php
// 条件分岐：今回はif文で説明;
$areTeacher = true;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1-4 PHPの書き方 | ノリと勢いで学ぶPHP実習</title>
</head>
<body>
    <h1>きんぐえるえむえす</h1>
    <!-- 条件分岐は出すべきデータを切り替える際にも使える -->
    
    <ul>
    <?php if ($areTeacher): ?>
        <li>課題・授業資料を登録する</li>
        <li>課題を採点する</li>
        <li>出席を確認する</li>
    <?php else: ?>
        <li>資料を確認する</li>
        <li>課題を提出する</li>
        <li>出席を登録する</li>
    <?php endif; ?>
    </ul>

    <ul>
    <!-- 以下のように書くこともできるが，上の書き方の方が好き -->
    <?php
        if ($areTeacher) {
            echo '<li>課題・授業資料を登録する</li>';
            echo '<li>課題を採点する</li>';
            echo '<li>出席を確認する</li>';
        }
        else {
            echo '<li>資料を確認する</li>';
            echo '<li>課題を提出する</li>';
            echo '<li>出席を登録する</li>';
        }
    ?>
    </ul>
</body>
</html>

