<?php
class View {
    // 呼び出し元から見た相対パスを設定します。
    private static $folderPath = './view/';

    // 引数にはデフォルト値を設定可能です。
    static function make($filename, $data = []) {
        foreach($data as $key => $value) {
            // 以前使った怪しい技を使います。
            $$key = $value;
        }
        require_once(self::getFilePath($filename));
    }
    
    // static なプロパティの場合は$が必要なので要注意です。
    private static function getFilePath($filename) {
        return self::$folderPath . $filename . '.php';
    }
}