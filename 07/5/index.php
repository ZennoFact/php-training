<?php
// このコンテンツは割とややこしいことしている気がしてきたので，
// そんなこともできるんだなー。くらいの気持ちで臨んでください。
require_once("./util/post.php");
// 新しく作ったクラスを読み込みます
require_once("./util/view.php"); 

$posts = [
    new Post("ぜんのー先生", "zenno.jpg", "授業資料作ってるとPHPがより楽しくなってきた。", "2020-05-20 12:00:00"),
    new Post("ぜんのー先生", "zenno.jpg", "やっぱりお腹がすきました。", (new DateTime())->modify('-15 day')->format('Y-m-d H:i:s')), // 引き算もできる
    new Post("ぜんのー先生", "zenno.jpg", "PHPのdatetimeのフォーマット，24時間表記はHです。", (new DateTime())->format('Y-m-d H:i:s')),
];

// ファイル名を指定し，タイトルとパラメータを設定した配列を渡します。
View::make('index', [
        "title" => "えっくす：ノリと勢いで学ぶPHP実習",
        "posts" => $posts,
    ]
);