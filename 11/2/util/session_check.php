<?php
session_start();

if(!isset($_SESSION['id'])) {
    // リダイレクト先を修正
    header("Location: ./login.php");
    exit;
}