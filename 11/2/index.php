<?php
require_once('./util/session_check.php');
require_once('./util/database.php');
require_once("./util/view.php"); 

$db = new Database("../sample.db");
$user = $db->getUser($_SESSION['id']);
$db->disconnect();

// ファイル名を指定し，タイトルとパラメータを設定した配列を渡します。
View::make('index', [
    'lessonNo' => '11-2',
    'user' => $user,
]);