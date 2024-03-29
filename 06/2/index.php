<?php
// 文字列の話
$helloWorld = 'Hello World';
// シングルクォーテーションはリテラル（直接記述した定数という表現で伝わるだろうか）として扱われるので，
// 変数の展開はされません。また，エスケープ（\）も無効化されます。

echo 'SingleQuotation: ' . $helloWorld . '\n<br>';
echo "DoubleQuotation: {$helloWorld}\n<br>"; // ダブルクォーテーションでは {} で囲むと変数の展開ができる

// ヒアドキュメント（変数に入れることも可能）
// 文字列を区切る別の方法としてヒアドキュメント構文 ("<<<") があります。
// <<< の後に任意の文字列を指定し、文字列（ID）を置いた後で、 
// 同じ ID (終端ID) を置いたところまでが改行や空白・タブを含めて文字列として扱われます。

$hereDoc = <<<EOT
よく，「EOT」ってつけるんだけど，これは「end of text」の略です。
ヒアドキュメントの開始時に終了時に指定するIDを定義して開始。
やりたいことやったら，終了時に指定したIDを書く。って感じ
    タブとか使える（HTMLに反映されるとは言っていない）し，
    改行もバンバン使える（HTMLに反映されるとは言っていない）けど，
ぶっちゃけ，インデント無視して書かないと無駄なタブやスペースが入りがちなので，うおってなる。
EOT;
echo $hereDoc;