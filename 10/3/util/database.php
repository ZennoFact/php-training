<?php

class Database {

    private $pdo;
    
    public function __construct($dbname) {
        try {
            $this->pdo = new PDO("sqlite:$dbname");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->init();
        } catch (Exception $e) {
            echo '接続に失敗しました。';
            echo $e->getMessage();
            exit;
        }
    }

    public function disconnect() {
        $this->pdo = null;
    }

    public function insertUser($id, $password, $name, $email) {
        $sql = 'insert into user (id, password, name, email, status) values (:id, :password, :name, :email, 0)';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return '追加しました。';
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }

    public function insertUsers($users) {
        $sql = 'insert into user (id, password, name, email, status) values (:id, :password, :name, :email, 0)';
        try {
            $stmt = $this->pdo->prepare($sql);
            foreach($users as $user) {
                $stmt->bindParam(':id', $user['id']);
                $stmt->bindParam(':password', $user['password']);
                $stmt->bindParam(':name', $user['name']);
                $stmt->bindParam(':email', $user['email']);
                $stmt->execute();
            }
            return '追加しました。';
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }

    // ログインの確認をして，成功すればIDを返し，失敗すればfalseを返すようにしました。
    public function loginProcess($id, $password) {
        // 必要な情報はIDとパスワードのみなので絞って取得します。
        $sql = 'select id, password from user where id = :id';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            // ユーザーが存在していない場合は $result は false になります。
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // ユーザーが存在していて，パスワードが一致していればIDを返します。
            if( $result && $result['password'] === $password) return $result['id'];
            return false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // 表に出すデータだけ返したい。
    public function getUser($id) {
        // サービス上で必要な id と 名前だけ返すようにしましょう。
        $sql = 'select id, name from user where id = :id';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getActiveUsers() {
        $sql = 'select * from user where status = 0';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateUser($id, $name, $email) {
        $sql = 'update user set name = :name, email = :email where id = :id';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return '更新しました。';
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function changePassword($id, $password) {
        $sql = 'update user set password = :password where id = :id';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            return 'パスワードを変更しました。';
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function disableUser($id) {
        $sql = 'update user set status = -1 where id = :id';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return '無効にしました。';
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function init() {
        $createTableSql = <<<EOS
CREATE TABLE IF NOT EXISTS user (
    id TEXT PRIMARY KEY,
    password TEXT,
    name TEXT,
    email TEXT,
    status INTEGER
)
EOS;
        $createUserStatusSql = <<<EOS
CREATE TABLE IF NOT EXISTS user_status (
    id INTEGER PRIMARY KEY,
    name TEXT
)
EOS;
        try {
            $this->pdo->query($createTableSql);
            $this->pdo->query($createUserStatusSql);
            $this->pdo->query("insert or ignore into user_status (id, name) values (-1, '無効')");
            $this->pdo->query("insert or ignore into user_status (id, name) values (0, '有効')");
    
            $this->insertUsers([
                ['id' => 'zenno'   , 'password' => 'test1', 'name' => 'ぜんのー', 'email' => 'test1@sample.admin', 'status' => 0], 
                ['id' => 'panpukin', 'password' => 'test2', 'name' => 'アダムスミス', 'email' => 'test2@sample.admin', 'status' => 0],
                ['id' => 'hedgehog', 'password' => 'test3', 'name' => 'はりねずみ', 'email' => 'test3@sample.admin', 'status' => 0]
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
} // class Database end