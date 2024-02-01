<?php
require_once('./util/session_check.php');
require_once('./util/database.php');
// 投稿（ポスト）を表すクラスを読み込みます。
require_once('./util/post.php');
require_once("./util/view.php"); 

$db = new Database("../sample.db");
$user = $db->getUser($_SESSION['id']);

// データベースから投稿を取得します。
$postList = $db->getAllPosts();
$db->disconnect();

foreach($postList as $post) {
    // 投稿の情報を使って，投稿のインスタンスを作成します。
    $posts[] = new Post(
        $post['id'],
        $post['user_id'],
        $post['image'],
        $post['extension'],
        $post['text'],
        $post['created_at']
    );
}

// 投稿の情報も，ビューに渡します。
View::make('index', [
    'lessonNo' => '11-2',
    'user' => $user,
    'posts' => $posts,
]);