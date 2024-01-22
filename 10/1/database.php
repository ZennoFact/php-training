<?php

class Database {

    private $pdo;
    
    // データベースへの接続と，不足している場合テーブルの作成を行います。
    public function __construct($dbname) {
        try {
            $this->pdo = new PDO("sqlite:$dbname");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // このユーザーが現在有効かどうかという情報をstatusというカラムに持たせることにします。
            $this->init();
        } catch (Exception $e) {
            echo '接続に失敗しました。';
            echo $e->getMessage();
            exit;
        }
    }

    // データベースへの接続を切断します。
    public function disconnect() {
        $this->pdo = null;
    }

    // データベースにユーザーデータを追加します。
    public function insertUser($userid, $password, $name, $email) {
        $sql = 'insert into user (userid, password, name, email) values (:userid, :password, :name, :email)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userid', $userid);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }

    // データベースからユーザーデータを取得します。
    public function getUser($userid) {
        $sql = 'select * from user where userid = :userid';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userid', $userid);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // データベースからユーザーデータを更新します。
    public function updateUser($userid, $password, $name, $email) {
        $sql = 'update user set password = :password, name = :name, email = :email where userid = :userid';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userid', $userid);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }

    // データベースからユーザーデータを無効にします
    public function disableUser($userid) {
        $sql = 'update user set status = -1 where userid = :userid';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userid', $userid);
        $stmt->execute();
    }

    // 初期化処理があまりにも長くなるので，基本はこんな風にプログラムからデータベースを初期化したりはしません。
    function init($pdo) {
        $sql = <<<EOS
CREATE TABLE IF NOT EXISTS user (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    userid TEXT,
    password TEXT,
    name TEXT,
    email TEXT,
    status INTEGER,
)
EOS;
        $this->pdo->query($sql);
        // ユーザーステータスを表すテーブルを作成します。
        $sql = <<<EOS
CREATE TABLE IF NOT EXISTS user_status (
    id INTEGER PRIMARY KEY,
    name TEXT
)
EOS;
        $this->pdo->query($sql);
        // ユーザーステータスのデータを入れます。(既に存在するデータは無視します)
        $this->pdo->query('insert or ignore into user_status (id, name) values (-1, "無効")');
        $this->pdo->query('insert or ignore into user_status (id, name) values (0, "有効")');
    }
} // class Database end