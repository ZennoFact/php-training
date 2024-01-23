<?php
// ログイン済みかのチェックはログイン後の全ページで共有する想定で
// session_check.php に切り出しました。
// ログイン前のページは1ページだけなのでそこだけは手で頑張る所存です。
session_start();

if(!isset($_SESSION['id'])) {
    header("Location: .");
    exit;
}