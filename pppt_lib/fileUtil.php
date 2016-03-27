<?php

class fileUtil {

    static function create_path() {
        if(func_num_args() < 1) { return ''; }
        $argv = func_get_args();
        if(!$argv) { return ''; }
        $argv = array_map(function($val) {
            return str_replace("\\", '/', $val);
        }, $argv);
        $first_slash = false;
        if('/' === substr($argv[0], 0, 1)) {
            $first_slash = true;
        }
        $argv = array_map(function($val) {
            return trim($val, '/');
        }, $argv);
        if($first_slash) {
            return '/'.implode('/', $argv);
        }
        return implode('/', $argv);
    }

    static function create_file($path) {
        $path = (string)$path;
        if(!$path || 'Array' === $path || 'Object' === $path) {
            return "Nothing create file path";
        }
        if(file_exists($path)) {
            return "file exist";
        }
        if(!self::create_dir($path)) {
            return "Failed to create dir";
        }
        if(!touch($path)) {
            return "Failed to create file";
        }
        return 'create';
    }

    static function create_dir($path) {
        $pathinfo = pathinfo($path);
        if($pathinfo['filename']) {
            $path = $pathinfo['dirname'];
        }
        if(is_dir($path)) {
            return true;
        }
        $path_items = explode(DIRECTORY_SEPARATOR, $path);
        $dir = '';
        foreach($path_items as $item) {
            $dir = self::create_path($dir, $item);
            if(is_dir($dir)) { continue; }
            if(!mkdir($dir)) { return false; }
        }
    }

    static function get_data_list($glob) {
        if(!$glob) { return []; }
        $dir = dirname($glob);
        $file_list = glob($glob);
        if(!$file_list) { return []; }
        sort($file_list);
        $data_list = array_map(function($val) use($dir) {
            return file($val);
        }, $file_list);
        return $data_list;
    }

}
