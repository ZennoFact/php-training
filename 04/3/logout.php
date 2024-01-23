<?php
// ログアウト処理については，セッションを破棄することで実現します。
// まずはsession_start()と，ログインしているかのチェック
session_start();

if(!isset($_SESSION['id'])) {
    header("Location: .");
    exit;
}

// 保存されたセッションの変数を空にする
$_SESSION = array(); 

// セッションを切断するにはセッションクッキーも削除する。
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    // cookieを破棄するが，セッション名，情報を空に，有効期限で過去を選択しないといけないけど...特に値が決められてないからこんな感じで，それ以降のパス，ドメイン，セキュア，httponlyの設定はそのままで指定している
    setcookie(session_name(), '', time() - 60,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}


// 最後にセッション自体の破棄
session_destroy();

// ログアウト後はログインページに戻す
header("Location: .");
exit;
// ログアウトだけできればいいので，画面は出しません。