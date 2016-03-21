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
//log::w('return:  '. log::v(implode('/', $argv)), __FILE__, __LINE__, __CLASS__, __FUNCTION__);

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
