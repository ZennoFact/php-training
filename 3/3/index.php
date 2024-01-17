<?php
// HTML関連だけでなく，関数とかクラスを書いたときにファイルを分けて作り，それを呼び出すためにrequireやincludeを使うことも多いです。
require_once('./functions.php');

// 画面で使うデータを用意
$title = "3-2 include と require";

// 現在の時間をdate関数で取得。その際，date関数の第一引数には，日付のフォーマットを指定します。
// Yは年，mは月，dは日，Hは24時間表記の時，iは分，sは秒です。
// Apacheの設定でタイムゾーンを日本にしていなければ，現在の日本時間ではない時刻（おそらくマイナス9時間）が返ってきます。
$now = date("Y年m月d日 H時i分s秒");

// 曜日はすんなり取れないので，今日の曜日を取得するfunctions.phpに自作した関数を呼び出して取得します
$weekday = getWeekday($now);

$message = "このページは{$now}，{$weekday}曜日にアクセスされました。";

// 画面情報（HTMLデータ）の読み込み
require_once('../html/'.basename(__FILE__));