<?php
session_start();

require_once("./util/view.php"); 

if(isset($_SESSION['id'])) {
    header("Location: .");
    exit;
}

$message = isset($_GET['message']) ? $_GET['message'] : ""; 

if( isset($_POST['id']) && isset($_POST['pw']) ) {

    require_once('./util/database.php');
    $db = new Database("../sample.db");

    $userId =  $db->loginProcess($_POST['id'], $_POST['pw']);
    $db->disconnect();

    if( $userId ) {
        session_regenerate_id(true);
        $_SESSION['id'] = $userId;
        
        header("Location: .");
    } else {
        $message = "IDかパスワードが間違っています。";
    }
}

// ファイル名を指定し，タイトルとパラメータを設定した配列を渡します。
View::make('login', [
    'lessonNo' => '11-2',
    'message' => $message,
]);