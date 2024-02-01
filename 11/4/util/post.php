<?php 
class Post {
    private $id;
    private $userId;
    private $iconImage;
    private $image;
    private $text;
    private $good;
    private $comments;

    // コンストラクタやメソッドの引数にはデフォルト値を設定できます。今回は，$goodと$commentsにデフォルト値を設定します。
    public function __construct($postId, $userId, $iconImage, $image, $text, $good = 0, $comments = []) {
        $this->id = $postId;
        $this->userId = $userId;
        $this->iconImage = $iconImage;
        $this->text = $text;
        $this->image = $image;
        $this->good = $good;
        $this->comments = $comments;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }
    
    public function getIconImage() {
        return $this->iconImage;
    }

    public function getText() {
        return $this->text;
    }

    public function getImage() {
        return $this->image;
    }

    public function getGood() {
        return $this->good;
    }

    public function getComments() {
        // ここは，コメントを取得する処理を書きますが，ちょっと変更の余地あり。
        return $this->comments;
    }
}
