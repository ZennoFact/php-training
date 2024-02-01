<?php
require_once('./util/session_check.php');
require_once('./util/database.php');
// 投稿（ポスト）を表すクラスを読み込みます。
require_once('./util/post.php');
require_once("./util/view.php"); 

$db = new Database("../sample.db");
$user = $db->getUser($_SESSION['id']);
$db->disconnect();

// サンプルの投稿の情報を作成します。最終的にデータベースから取得するようにします。
$posts = [
    new Post(1, "zenno", "", "", "Hello world."),
    new Post(2, "zenno", "", "", "I love programming.", 2, ["どんなプログラミング言語が好きなん？"]), // コメントを追加します。
    new Post(3, "zenno", "", "", "Enjoy your student life.", 8),
];

// 投稿の情報も，ビューに渡します。
View::make('index', [
    'lessonNo' => '11-2',
    'user' => $user,
    'posts' => $posts,
]);