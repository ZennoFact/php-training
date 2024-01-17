<?php
// formを使ってGETやPOSTでデータを送ると，そのデータは$_GETや$_POSTという変数に格納されます
// 別のPHPファイルを指定してもいいけど，学習初期はデータを送るのも受け取るのも1つのファイルで実施することが多いです
// 今回も1つのファイルでGETの練習をするので，このファイルで受け取りの処理から書いていきます。

// まずは$_GETにデータが入っているか確認します
// 以下の1行だけ書いて，ブラウザでページを確認し，下のformに何か文章を入れて検索ボタンを押してください。
var_dump($_GET);
// 何も入っていないときはarray(0) { }と表示されます。
// 何か入れたらarray(1) { ["classId"]=> string(n) "入力した内容" }のように表示されます。
// 確認したら，var_dump($_GET);の行は削除するかコメントアウトしてください

// 今回のプログラムでは，GETで送られてきたデータを使って，科目番号から科目名を検索するプログラムを作ります 
// そのため，1-5で作った連想配列をもってきました。
$studentsClassList = array(
    "002" => "計算機システム概論２",
    "004" => "アルゴリズム２",
    "008" => "システム設計",
    "012" => "Java実習２",
    "014" => "PHP実習",
    "020" => "ITリテラシー",
);

// ここからGETで送られてきたデータを使って，科目名を検索する処理を書いていきます
// まずはGETで送られてきたデータを $_GET['キー'] の形で受け取ります（確認したら下のechoは消してOK）
echo $_GET['classId'];
// これだけで，GETで送られてきたデータを受け取ることができますが，データが送られない最初のアクセスではエラーが出ます。
// Warning: Undefined array key "classId" in ～ って感じで。classIdっていう名前で送られてくるGETデータはないよって感じのエラーです。
// なので，最初のアクセスのときはエラーが出ないように，isset関数を使って，GETで送られてきたデータがあるか確認します。

// isset関数は，変数に値がセットされているか確認する関数です。戻り値はtrueかfalseです。
// if文とセットで使ってみましょう
$className = "";
if(isset($_GET['classId'])) {
    $className = $studentsClassList[$_GET['classId']];
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2-2 ページをまたいだデータの移動 | ノリと勢いで学ぶPHP</title>
</head>
<body>
    <h1>GETの練習</h1>
    <!-- actionを指定しなければこのファイルという扱いになります。 -->
    <!-- 今回の例では空白でも「.」でも「./」でも「index.php」でも「./index.php」でも同じファイル（PHP）にデータを送ることになります。 -->
    <!-- ファイルのパス（保存場所）とその指定方法はしっかり学んでおいてください。 -->
    <form action="." method="get">
        <label for="className">科目ID</label><input id="classId" type="text" name="classId"><br>
        <input type="submit" value="検索">
    </form>
    <p>検索結果：<?php echo $className; ?></p>
</body>
</html>