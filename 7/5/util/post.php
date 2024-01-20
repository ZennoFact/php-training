<?php
// このファイルは変えてません。
class Post {
    const ICON_PATH = './icon/';

    private $name;
    private $text;
    private $datetime;
    private $icon;

    public function __construct($name, $icon, $text, $datetime) {
        $this->name = $name;
        $this->icon = self::ICON_PATH . $icon;
        $this->text = $text;
        $this->datetime = new DateTime($datetime);
    }

    public function show() {
        echo " {$this->name} 「{$this->text}」 ({$this->whenWasItPosted()})";
    }

    public function getIconPath() {
        return $this->icon;
    }

    private function whenWasItPosted() {
        $now = new DateTime();
        $elapsedTime = $now->diff($this->datetime);
        if($elapsedTime->y > 0) return $elapsedTime->format('%y年');
        if($elapsedTime->m > 0) return $elapsedTime->format('%mヶ月');
        if($elapsedTime->d > 0) return $this->datetime->format('n月j日');
        if($elapsedTime->h > 0) return $elapsedTime->format('%h時間');
        if($elapsedTime->i > 0) return $elapsedTime->format('%i分');
        if($elapsedTime->s > 10) return $elapsedTime->format('%s秒');
        return 'たった今';
    } 
}