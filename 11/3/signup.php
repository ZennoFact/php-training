<?php
session_start();

require_once("./util/view.php"); 

if(isset($_SESSION['id'])) {
    header("Location: .");
    exit;
}

$id = isset($_POST['id']) ? $_POST['id'] : "";
$pw = isset($_POST['pw']) ? $_POST['pw'] : "";
$name = isset($_POST['name']) ? $_POST['name'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$message = "";

if( isset($_POST['id']) && isset($_POST['pw']) && isset($_POST['name']) && isset($_POST['email']) ) {
    require_once('./util/database.php');
    $db = new Database("../sample.db");

    // 画像ファイルがあれば取得
    $file = isset($_FILES['userfile']) ? $_FILES['userfile'] : null;
    $result =  $db->sighUpProcess($_POST['id'], $_POST['pw'], $_POST['name'], $_POST['email'], $file);
    $db->disconnect();
    
    if( $result['isSuccess'] ) {


        header("Location: ./login.php?message={$result['message']}");
    } else {
        $message = $result['message'];
    }
} else if(isset($_GET)) {
    $message = "登録に必要な情報は全て入力してください。";
}

// ファイル名を指定し，タイトルとパラメータを設定した配列を渡します。
View::make('signup', [
    'lessonNo' => '11-2',
    'id' => $id,
    'pw' => $pw,
    'name' => $name,
    'email' => $email,
    'message' => $message,
]);