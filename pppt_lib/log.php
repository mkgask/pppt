<?php

class log {

    static $log_path = '';

    static function w($write, $file = '', $line = '', $class = '', $function = '') {
        if($file && $line && $class && $function) {
            $write = "$file:$line : $class::$function : $write";
        }
        list($usec, $sec) = explode(" ", microtime());
        $usec = substr($usec, 1);
        $ymdhis = date('Y/m/d H:i:s', $sec);
        return file_put_contents(
            self::path(),
            "[ $ymdhis $usec ] $write".PHP_EOL,
            FILE_APPEND
        );
    }

    static function path() {
        if(self::$log_path) {
            return self::$log_path;
        }
        $log_dir = __DIR__.'/log/';
        if(!is_dir($log_dir)) { mkdir(__DIR__.'/log/'); }
        self::$log_path = $log_dir. date('Ymd').'.log';
        return self::$log_path;
    }

    static function v($value) {
        if(is_null($value)) {
            return 'null';
        }
        if(is_object($value)) {
            return print_r((array)$value, true);
        }
        if(is_array($value)) {
            return print_r($value, true);
        }
        if(is_bool($value)) {
            return ($value) ? 'true' : 'false';
        }
        return (string)$value;
    }
}