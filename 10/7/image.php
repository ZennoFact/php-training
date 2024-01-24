<?php
// 登録された画像を表示するための処理を書きます。
require_once('./util/session_check.php');
require_once('./util/database.php');

$image = fopen('./images/accounts/@no_image.png', 'rb');
$extension = 'jpeg';

// POSTされたID情報があれば，
if( isset($_GET['v']) ){
    $db = new Database("../sample.db");
    $result = $db->getUserImage($_GET['v']);
    $db->disconnect();
    
    $image = $result['image'] ;
    // 拡張子が「jpg」の場合は「jpeg」に変更します。 
    $extension = $result['extension'] === 'jpg' ? 'jpeg' : $result['extension'] ;

}

// 画像の種類によって，Content-typeを変更します。
header("Content-type: image/{$extension}");
// 画像をブラウザ側に返します。
echo $image;