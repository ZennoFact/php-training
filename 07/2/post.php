<?php
// コンストラクタは最強に便利なので，ガンガン活用しましょう。
class Post {
    // プロパティを可能な限りprivateにして，外部からのアクセスを制限しましょう。    
    private $name;
    private $text;

    // コンストラクタは，クラスのインスタンスを作成するときに自動的に実行されるメソッドです。
    // 引数を指定して色々することが多いです。
    // 今回は，nameとtextを引数に指定して，それぞれのプロパティに代入しています。
    public function __construct($name, $text) {
        $this->name = $name;
        $this->text = $text;
    }

    public function show() {
        echo "{$this->name} 「{$this->text}」";
    }
}