<?php
// ユーザー登録と，ログイン処理を修正します。
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

    public function sighUpProcess($id, $password, $name, $email) {
        $sql = 'select id from user where id = :id';
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if($stmt->fetch(PDO::FETCH_ASSOC)) {
                return [
                    'isSuccess' => false,
                    'message' => 'IDがすでに登録されています。別のIDを入力してください。',
                ];
            }
            $result = $this->insertUser($id, $password, $name, $email);
            $this->pdo->commit();

            return $result;
        } catch (Exception $e) {
            $pdo->rollBack();
            return  $e->getMessage();
        }
    }

    // パスワードをそのまま（「平文で」と表現することが多いです）保存するのは危険です。
    // データベースに保存しているデータが見られてしまった場合，パスワードがそのまま見られてしまいます。
    // そのため，httpsで通信を暗号化し，データベースに保存する前にハッシュ化する必要があります。
    // ハッシュ化とは，「あるデータを特定のルールに従って変換すること」です。
    // 登録時にハッシュ化を行います
    public function insertUser($id, $password, $name, $email) {
        // password_hash関数を使うと，ハッシュ化を行うことができます。
        // password_hash関数の第二引数には，ハッシュ化のルールを指定することができます。
        // が，PHPは「デフォルトで十分安全やから基本的に PASSWORD_DEFAULT 使っといて」と言っています。
        $hash = password_hash($password, PASSWORD_DEFAULT);
        // echo $hash; // 一度，ハッシュ化されたパスワードを確認しておきましょう（覚える必要はないです）
        $sql = 'insert into user (id, password, name, email, status) values (:id, :password, :name, :email, 0)';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            // ハッシュ化したパスワードを保存します。
            $stmt->bindParam(':password', $hash);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return [
                'isSuccess' => true,
                'message' => 'ユーザー登録が完了しました。',
            ];
        } catch (Exception $e) {
            return [
                'isSuccess' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function insertUsers($users) {
        $sql = 'insert into user (id, password, name, email, status) values (:id, :password, :name, :email, 0)';
        try {
            $stmt = $this->pdo->prepare($sql);
            foreach($users as $user) {
                // こちらも，同じようにハッシュ化したパスワードを保存します。
                $hash = password_hash($user['password'], PASSWORD_DEFAULT);
                // echo $hash; // 一度，ハッシュ化されたパスワードを確認しておきましょう（覚える必要はないです）
                $stmt->bindParam(':id', $user['id']);
                $stmt->bindParam(':password', $hash);
                $stmt->bindParam(':name', $user['name']);
                $stmt->bindParam(':email', $user['email']);
                $stmt->execute();
            }
            return '追加しました。';
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }

    // パスワードをハッシュ化したらログインチェックも変更する必要があります。
    public function loginProcess($id, $password) {
        $sql = 'select id, password from user where id = :id';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // ハッシュ化したパスワードをpassword_verify関数に渡すと，ハッシュ化されたパスワードと比較してくれます。
            // 第1引数に入力されたパスワード，第2引数にハッシュ化されたパスワードを渡します。
            if( $result && password_verify($password, $result['password']) ) return $result['id'];
            return false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUser($id) {
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