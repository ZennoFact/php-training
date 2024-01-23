<?php
// PHPでもクラスが書けます。いい時代が来ましたね。では，書いていきましょう
class Post {
    // ここにプロパティを書いていきます（いわゆるメンバ変数，インスタンス変数と呼ばれるもの）
    public $name;
    public $text;

    // メソッドもかけます
    public function show() {
        echo "{$this->name} 「{$this->text}」";
    }
}