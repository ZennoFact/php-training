<?php
// phpinfo();
// POSTによるファイルアップロードには細かいルールが存在します。
// HTMLの段階で気を付けることはHTMLのフォームのenctype属性をmultipart/form-dataにすることです。
// inputタグのtype属性をfileにすることも忘れないようにしましょう。（下部参照）
// なお，場合によってはサーバ側の設定（私の環境ではXAMPPから起動しているApacheの設定（php.ini））を変更する必要があります。

$message = "";
// POSTを使っても転送されてきたファイルへのアクセスは$_POSTではなく$_FILESで行います。
// ファイルが送られてきていたら？
if(isset($_FILES['userfile'])) {
    // 送られてきたファイルを確認してみましょう。"name"で元のファイル名が取れていると思います。
    var_dump($_FILES['userfile']);
    // 確認できたら上のvar_dumpは削除orコメントアウトしてください。

    // アップロードしたファイルを格納するパスの設定
    $uploaddir = './uploads/';
    // 今回はファイルを元の名称で保存することにします。
    // basename関数は，パスからファイル名のみを綺麗に取り出す関数です。
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

    // ファイルがアップロードされると一時的な場所（メモリ）に保存されます。
    // その場所から指定した場所に移動させることで，サーバ上へのファイルの保存が完了します。
    // 一時ファイルの移動はmove_uploaded_file関数を使います。
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        $message = "ファイルのアップロードに成功しました。";
    } else {
        $message = "ファイルのアップロードに失敗しました。";
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2-5 ページをまたいだデータの移動 | ノリと勢いで学ぶPHP</title>
</head>
<body>
    <h1>ファイルアップロードの練習</h1>
    <form enctype="multipart/form-data" action="." method="post">
        <!-- MAX_FILE_SIZE は、必ず "file" input フィールドより前に設定（サイズはバイト）今回は4Mバイト -->
        <input type="hidden" name="MAX_FILE_SIZE" value="4000000">
        <!-- inputタグのname属性を使ってPHPはファイルを取得します。今回は画像ファイル（png,jpeg）に絞りました -->
        <input name="userfile" type="file" accept="image/png, image/jpeg"/>
        <input type="submit" value="アップロード">
    </form>
    <!-- 結果をメッセージとして出力しましょう -->
    <p><?php echo $message; ?></p>
    <!-- 登録されている画像を表示します -->
    <div>
        <?php foreach(glob('./uploads/*') as $filepath): ?>
            <img src="<?= $filepath ?>" alt="">
        <?php endforeach; ?>
    </div>
</body>
</html>