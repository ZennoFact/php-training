<?php

$title = "3-2 include と require";
$message = "分割したファイルがくっついてる！";

// 今回のパスは呼び出し元（このファイル）からの相対パスで書いている
// requireは必ず必要なファイルを呼び出すときに使います。（ミスるとエラー吐いて止まります）
// require_onceは，呼び出すファイルが既に呼び出されている場合は，もう呼び出さないという便利な関数です。
require_once("../html/index.php");
// 今回の書き方で最も大きなメリットは，複数にページにまたがるHTMLの共通パーツの修正時に，一箇所のファイルを修正するだけで済むということです。
// 上と下の書き方を見比べてほしいのですが，（そしてコメントアウトしながら両方が動くことを確認してほしいのですが）
// PHPはプログラムを書いているファイル自体の情報も取得できます。__FILE__ という定数を使うのですが，以下のような形で書くことができます。
require_once('../html/'.basename(__FILE__));
// このように書くと，自ファイル名とhtmlとして使いたいファイル名を同じにして，
// 保存先さえ間違えなければいちいちファイル名を書き換える必要がなくなり便利かもしれません。
