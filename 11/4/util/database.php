<?php
// がっつり修正します。
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

            $filePath = self::NO_IMAGE;
            $extension = 'jpeg';
            if ($file) {
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filePath = $file['tmp_name'];
            }

            $result = $this->insertUser($id, $password, $name, $email, $filePath, $extension);
            $this->pdo->commit();

            return $result;
        } catch (Exception $e) {
            $pdo->rollBack();
            return  $e->getMessage();
        }
    }

    public function insertUser($id, $password, $name, $email, $image, $extension) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $blob = fopen($image, 'rb') ;
        
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

    public function insertUsers($users) {
        $sql = 'insert into user (id, password, name, email, image, extension, status) values (:id, :password, :name, :email, :image, :extension, 0)';
        try {
            
            $stmt = $this->pdo->prepare($sql);
            foreach($users as $user) {
                $blob = fopen($user['image'], 'rb') ;
                $extension = pathinfo($user['image'], PATHINFO_EXTENSION);

                $hash = password_hash($user['password'], PASSWORD_DEFAULT);
                $stmt->bindParam(':id', $user['id']);
                $stmt->bindParam(':password', $hash);
                $stmt->bindParam(':name', $user['name']);
                $stmt->bindParam(':email', $user['email']);
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

    public function getUserImage($id) {
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

    public function getImage($id) {
        $sql = 'select image, extension from post where id = :id';
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
    // 投稿を追加するメソッドを作成します。
    function insertPost($userId, $imagePath, $text) {
        $sql = 'insert into post (id, user_id, image, extension, text, created_at) values (:id, :user_id, :image, :extension, :text, :created_at)';
        try {
            $now = (new DateTime())->format('Y-m-d H:i:s');

            $stmt = $this->pdo->prepare($sql);
            $blob = fopen($imagePath, 'rb') ;
            $extension = pathinfo($imagePath, PATHINFO_EXTENSION);

            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':image', $blob, PDO::PARAM_LOB);
            $stmt->bindParam(':extension', $extension);
            $stmt->bindParam(':text', $text);
            $stmt->bindParam(':created_at', $now);
            $stmt->execute();
            return '追加しました。';
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    } 

    // 投稿を1件取得するメソッドを作成します。
    function getPost($id) {
        $sql = 'select * from post where id = :id';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // 投稿を全件取得するメソッドを作成します。
    function getPosts($userId) {
        $sql = 'select * from post where user_id = :user_id';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }   

    function getAllPosts() {
        $sql = 'select * from post';
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }   
    

    // 追加
    private function init() {
        $createTableSql = <<<EOS
CREATE TABLE IF NOT EXISTS user (
    id TEXT PRIMARY KEY,
    password TEXT,
    name TEXT,
    email TEXT,
    image TEXT,
    extension TEXT,
    status INTEGER,
    profile TEXT
)
EOS;
        $createUserStatusSql = <<<EOS
CREATE TABLE IF NOT EXISTS user_status (
    id INTEGER PRIMARY KEY,
    name TEXT
)
EOS;
// テーブルを増やします（後でさらに追加するかも）
        $createPostSql = <<<EOS
CREATE TABLE IF NOT EXISTS post (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id TEXT,
    image TEXT,
    extension TEXT,
    text TEXT,
    created_at TEXT
)
EOS;
        $createGoodSql = <<<EOS
CREATE TABLE IF NOT EXISTS good (
    post_id INTEGER,
    user_id TEXT,
    PRIMARY KEY (post_id, user_id)
)
EOS;
        $createCommentSql = <<<EOS
CREATE TABLE IF NOT EXISTS comment (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    post_id INTEGER,
    user_id TEXT,
    text TEXT,
    created_at TEXT
)
EOS;
        $createfollowSql = <<<EOS
CREATE TABLE IF NOT EXISTS follow (
    user_id TEXT,
    follower_id TEXT,
    PRIMARY KEY (user_id, follower_id)
)
EOS;
        try {
            $this->pdo->query($createTableSql);
            $this->pdo->query($createUserStatusSql);
            $this->pdo->query($createPostSql);
            $this->pdo->query($createGoodSql);
            $this->pdo->query($createCommentSql);
            $this->pdo->query($createfollowSql);
            $this->pdo->query("insert or ignore into user_status (id, name) values (-1, '無効')");
            $this->pdo->query("insert or ignore into user_status (id, name) values (0, '有効')");
    
            $this->insertUsers([
                ['id' => 'zenno'   , 'password' => 'test1', 'name' => 'ぜんのー', 'email' => 'test1@sample.admin', 'image' => self::ACCOUNT_IMAGE_FOLDER . 'zenno.jpg', 'status' => 0], 
                ['id' => 'panpukin', 'password' => 'test2', 'name' => 'アダムスミス', 'email' => 'test2@sample.admin', 'image' => self::ACCOUNT_IMAGE_FOLDER . 'panpukin.jpg', 'status' => 0],
                ['id' => 'hedgehog', 'password' => 'test3', 'name' => 'はりねずみ', 'email' => 'test3@sample.admin', 'image' => self::NO_IMAGE, 'status' => 0]
            ]);

            $hasPost = $this->pdo->query("select id from post")->fetch(PDO::FETCH_ASSOC);
            if (!$hasPost) {
                $posts = [
                    ["zenno", "./images/post/sample1.png", "Hello world."],
                    ["zenno", "./images/post/sample2.png", "I love programming."],
                    ["zenno", "./images/post/sample3.png", "Enjoy your student life."],
                ];
    
                foreach($posts as $post) {
                    $this->insertPost($post[0], $post[1], $post[2]);
                }
            }

        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
} // class Database end