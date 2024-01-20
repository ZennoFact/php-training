<?php
class Post {
    // プロパティを一つ増やしました    
    private $name;
    private $text;
    private $datetime;

    // プロパティが増えたので，コンストラクタもそれに合わせて変更しました。
    public function __construct($name, $text, $datetime) {
        $this->name = $name;
        $this->text = $text;
        $this->datetime = new DateTime($datetime);
    }

    // ここで，$datetimeを返すメソッドを使用
    public function show() {
        echo "{$this->name} 「{$this->text}」 ({$this->whenWasItPosted()})";
    }

    // 内部からしか使わない関数は，privateにしておくと良いです。
    // 〇週間前とかは作ってないけど，こんな感じで投稿の時間を表示する関数を作ってみました。
    private function whenWasItPosted() {
        $now = new DateTime();
        $elapsedTime = $now->diff($this->datetime);
        // var_dump($elapsedTime); // 一度，$elapsedTimeの中身を確認してみましょう。
        if($elapsedTime->y > 0) return $elapsedTime->format('%y年');
        if($elapsedTime->m > 0) return $elapsedTime->format('%mヶ月');
        if($elapsedTime->d > 0) return $this->datetime->format('n月j日'); // nは0埋めしない月，jは0埋めしない日
        if($elapsedTime->h > 0) return $elapsedTime->format('%h時間');
        if($elapsedTime->i > 0) return $elapsedTime->format('%i分');
        if($elapsedTime->s > 10) return $elapsedTime->format('%s秒');
        return 'たった今';
    } 
}