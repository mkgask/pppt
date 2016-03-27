<?php
/**
 * create input check file
 */
call_user_func(function() use($argc, $argv) {
    require __DIR__.'/autoload.php';
    $current_dir = getcwd();

    if(2 > $argc) {
        throw new Exception("There is no specification of argument.", 1);
    }

    $target_name = trim($argv[1]);
    $target_num  = (int)$argv[2];

    $input_path = fileUtil::create_path($current_dir, $target_name, 'input-{{id}}.txt');
    $check_path = fileUtil::create_path($current_dir, $target_name, 'check-{{id}}.txt');

    array_map(function($val) use($input_path, $check_path) {
        $input_path = str_replace('{{id}}', $val, $input_path);
        $check_path = str_replace('{{id}}', $val, $check_path);
        $in_err = false;
        $ch_err = false;

        $msg = fileUtil::create_file($input_path);
        echo $msg, ' : ', $input_path, PHP_EOL;

        $msg = fileUtil::create_file($check_path);
        echo $msg, ' : ', $check_path, PHP_EOL;

    }, array_keys(array_fill(1, $target_num, '')));

});
