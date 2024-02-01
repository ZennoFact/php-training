<?php
// 7-5から流用
class View {
    private static $folderPath = './view/';

    static function make($filename, $data = []) {
        foreach($data as $key => $value) {
            $$key = $value;
        }
        require_once(self::getFilePath($filename));
    }
    
    private static function getFilePath($filename) {
        return self::$folderPath . $filename . '.php';
    }
}