<?php
// 反復処理：今回はfor文とforeach文で説明
$areTeacher = false;

// 将来的にこういったデータはデータベースに登録し，データベースから取得することになる
$teachersClasses = array(
    "ノリと勢いで学ぶPHP",
    "ドキドキオフィスアワー",
    "オープンキャンパスの授業",
    "プロジェクト演習３",
    "プロジェクト演習４",
);

$studentsClasses = array(
    "計算機システム概論２",
    "アルゴリズム２",
    "システム設計",
    "Java実習２",
    "PHP実習",
    "ITリテラシー",
);

// 連想配列として保持する例。キーと値のペアでデータを保持する。
// 今回のキーは授業IDのイメージ
$studentsClassList = array(
    "002" => "計算機システム概論２",
    "004" => "アルゴリズム２",
    "008" => "システム設計",
    "012" => "Java実習２",
    "014" => "PHP実習",
    "020" => "ITリテラシー",
);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1-5 PHPの書き方 | ノリと勢いで学ぶPHP実習</title>
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
                <?php for ($i=0; $i < count($teachersClasses); $i++): ?>
                    <li><?= $teachersClasses[$i] ?></li>    
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
                <p>配列の出力例</p>
                <!-- foreach文を使うと先頭から一つずつ順番にとるということをシンプルに書ける -->
                <?php foreach ($studentsClasses as $class): ?>
                    <li><?= $class ?></li>
                <?php endforeach; ?>
                </ul>
                <ul>
                <p>連想配列での出力例</p>
                <!-- 連想配列をforeachで回す例 -->
                <?php foreach ($studentsClassList as $classId => $class): ?>
                    <li><?= $classId ?>: <?= $class ?></li>
                <?php endforeach; ?>
                </ul>     
            </div>
        </li>
    <?php endif; ?>
    </ul>
</body>
</html>

