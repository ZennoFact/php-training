<?php
// PHPでは必要に応じてファイルを分割し，読み込んでいくということができるようになります。
// 練習がてら，このHTMLファイルから共通部分を切り出して，別のファイルにしてみましょう。（分けた形は3-2を参照）
?>
<!-- ここから，共通のパーツ -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title | ノリと勢いで学ぶPHP</title><!-- ただし，Titleはページごとに変わる = 変数の出番 -->
</head>
<body>
    <header>
        <h1>Title</h1><!-- ここもページごとに変わるはず = 変数の出番 -->
    </header>
    <div>
    <!-- ここまで，共通のパーツ -->
    
    <!-- ここから，各ページごとに変わるパーツ -->

    <!-- ここまで，各ページごとに変わるパーツ -->
    
    <!-- ここから，共通のパーツ -->
    </div>
    <footer></footer>
</body>
</html>
<!-- ここまで，共通のパーツ -->