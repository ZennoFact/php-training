<?php
$studentsClassList = array(
    "002" => "計算機システム概論２",
    "004" => "アルゴリズム２",
    "008" => "システム設計",
    "012" => "Java実習２",
    "014" => "PHP実習",
    "020" => "ITリテラシー",
);

// GETの送信は，URLの後ろに送信したキーと値がくっつきます。
// PCでYouTube見たときに，動画のページにURLの後ろに「watch?v=～」っていうのがくっついていることに気づきましたか？;
// あれはGETで送信された動画の情報です。この情報をもとに同じページで見たい動画の情報を取り出せるし，URLでみんなにシェアすることもできます。
// つまり，Webページから送信せずに，直接URLを書き換えて情報を引き出すことができるということです。このへんがGETの利点かなと。

// isset関数は，変数に値がセットされているか確認する関数です。戻り値はtrueかfalseです。
// if文とセットで使ってみましょう
$className = "";
if(isset($_GET['classId'])) {
    // 正しいデータを入力してもらえなかったときの処理も大切です。今回は連想配列内にキーが存在するかをarray_key_exists関数で確認して処理を分岐させることにしました。
    if(array_key_exists($_GET['classId'], $studentsClassList)) {
        $className = $studentsClassList[$_GET['classId']];
    } else {
        $className = "科目が見つかりませんでした";
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2-3 ページをまたいだデータの移動 | ノリと勢いで学ぶPHP</title>
</head>
<body>
    <h1>GETの練習</h1>
    <form action="." method="get">
        <label for="className">科目ID</label><input id="classId" type="text" name="classId"><br>
        <input type="submit" value="検索">
    </form>
    <p>検索結果：<?= $className ?></p>
</body>
</html>