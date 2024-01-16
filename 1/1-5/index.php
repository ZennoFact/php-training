<?php
// 反復処理：今回はfor文とforeach文で説明
$areTeacher = true;

$teachersClass = array(
    "ノリと勢いで学ぶPHP",
    "ドキドキオフィスアワー",
    "オープンキャンパスの授業",
    "プロジェクト演習３",
    "プロジェクト演習４",
);

$studentsClass = array(
    "Java実習２",
    "アルゴリズム２",
    "PHP実習",
    "計算機システム概論２",
    "システム設計",
    "ITリテラシー",
);
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
    <ul>
    <?php if ($areTeacher): ?>
        <li>課題・授業資料を登録する</li>
        <li>課題を採点する</li>
        <li>
            <div>
                <p>出席を確認する</p>
                <ul>
                <!-- 反復処理を使って人ごとに異なる画面を効率よく書いていこう -->
                <?php for ($i=0; $i < count($teachersClass); $i++): ?>
                    <li><?= $teachersClass[$i] ?></li>    
                <?php endfor; ?>
                </ul>
            </div>
        </li>
    <?php else: ?>
        <li>資料を確認する</li>
        <li>課題を提出する</li>
        <li>
            <div>
                <p>出席を登録する</p>
                <ul>
                <?php foreach ($studentsClass as $class): ?>
                    <li><?= $class ?></li>
                <?php endforeach; ?>
                </ul>     
            </div> 
        </li>
    <?php endif; ?>
    </ul>
</body>
</html>

