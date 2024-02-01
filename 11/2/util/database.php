<?php
// ユーザー登録と，ログイン処理を修正します。
class Database {
    private const ACCOUNT_IMAGE_FOLDER = './images/accounts/';
    private const NO_IMAGE = self::ACCOUNT_IMAGE_FOLDER . '@no_image.png';
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

    public function sighUpProcess($id, $password, $name, $email, $file) {
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

            // 画像ファイルのアップロード処理を追加します。
            $filePath = self::NO_IMAGE;
            $extension = 'jpeg';
            if ($file) {
                // 拡張子の取得(pathinfo関数の第2引数に定数を指定すると拡張子が取得できます。)
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                // 一時ファイルから直接データを保存するためパスは取得しますが，ファイル自体は移動させません。
                $filePath = $file['tmp_name'];
            }

            // 画像のパスも引数で渡します
            $result = $this->insertUser($id, $password, $name, $email, $filePath, $extension);
            $this->pdo->commit();

            return $result;
        } catch (Exception $e) {
            $pdo->rollBack();
            return  $e->getMessage();
        }
    }

    // 画像のパスも保存するように修正します。
    public function insertUser($id, $password, $name, $email, $image, $extension) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        // 指定された画像ファイルをバイナリ形式で読み込み
        $blob = fopen($image, 'rb') ;
        
        // 列が増えたので，SQL文を修正します。
        $sql = 'insert into user (id, password, name, email, image, extension, status) values (:id, :password, :name, :email, :image, :extension, 0)';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':password', $hash);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':image', $blob, PDO::PARAM_LOB);
            $stmt->bindParam(':extension', $extension);
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

    // 初期化の際に使用するメソッドです。
    public function insertUsers($users) {
        // 列が増えたので，SQL文を修正します。
        $sql = 'insert into user (id, password, name, email, image, extension, status) values (:id, :password, :name, :email, :image, :extension, 0)';
        try {
            
            $stmt = $this->pdo->prepare($sql);
            foreach($users as $user) {
                // 指定された画像ファイルをバイナリ形式で読み込み
                $blob = fopen($user['image'], 'rb') ;
                // 拡張子も取得します。
                $extension = pathinfo($user['image'], PATHINFO_EXTENSION);

                $hash = password_hash($user['password'], PASSWORD_DEFAULT);
                $stmt->bindParam(':id', $user['id']);
                $stmt->bindParam(':password', $hash);
                $stmt->bindParam(':name', $user['name']);
                $stmt->bindParam(':email', $user['email']);
                // bindする内容をBLOBに対応させます。安全に行くならどの項目も今回の第2引数のように定数を使うべきです。
                $stmt->bindParam(':image', $blob, PDO::PARAM_LOB);
                $stmt->bindParam(':extension', $extension);
                $stmt->execute();

            }
            return '追加しました。';
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }

    public function loginProcess($id, $password) {
        $sql = 'select id, password from user where id = :id';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if( $result && password_verify($password, $result['password']) ) return $result['id'];
            return false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getUser($id) {
        // 画像はここでは取得しません。Webページで表示するときに取得できるように,「image.php」に処理を書きます。
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

    // 画像を取り出す処理を書きます。
    public function getUserImage($id) {
        // IDに合致する，画像と拡張子を取得します。
        $sql = 'select image, extension from user where id = :id';
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
        // テーブルの画像ファイルは「BLOB（Binary Large OBject : 要するに画像そのまま）」として格納するよう変更
        // また，「拡張子」を保存する列を追加
        $createTableSql = <<<EOS
CREATE TABLE IF NOT EXISTS user (
    id TEXT PRIMARY KEY,
    password TEXT,
    name TEXT,
    email TEXT,
    image TEXT,
    extension TEXT,
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
                ['id' => 'zenno'   , 'password' => 'test1', 'name' => 'ぜんのー', 'email' => 'test1@sample.admin', 'image' => self::ACCOUNT_IMAGE_FOLDER . 'zenno.jpg', 'status' => 0], 
                ['id' => 'panpukin', 'password' => 'test2', 'name' => 'アダムスミス', 'email' => 'test2@sample.admin', 'image' => self::ACCOUNT_IMAGE_FOLDER . 'panpukin.jpg', 'status' => 0],
                ['id' => 'hedgehog', 'password' => 'test3', 'name' => 'はりねずみ', 'email' => 'test3@sample.admin', 'image' => self::NO_IMAGE, 'status' => 0]
            ]);


        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
} // class Database end