<?php
require_once('./util/session_check.php');
require_once('./util/database.php');

$extension = 'jpeg';

if( isset($_GET['v']) ){
    $db = new Database("../sample.db");
    $result = $db->getImage($_GET['v']);
    $db->disconnect();
    
    $image = $result['image'] ;
    $extension = $result['extension'] === 'jpg' ? 'jpeg' : $result['extension'] ;

}

header("Content-type: image/{$extension}");
echo $image;