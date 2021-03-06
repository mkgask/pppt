<?php

call_user_func(function() use($argc, $argv) {

    // Initialize
    require __DIR__.'/autoload.php';
    $current_dir = getcwd();

    // get target php file path
    if(2 > $argc) {
        throw new Exception("There is no specification of argument.", 1);
    }

    $target_name = $argv[1];
    $target_path = fileUtil::create_path($current_dir, $target_name, 'answer.php');
    if(!is_file($target_path)) {
        throw new Exception("Can't find test php file.\n{$target_path}", 2);
    }

    // get input data file path
    if(array_key_exists(2, $argv)) {
        $input_name = $argv[2];
    } else {
        $input_name = 'input-*.txt';
    }
    $input_path = fileUtil::create_path($current_dir, $target_name, $input_name);
    $input_data_list = fileUtil::get_data_list($input_path);
    if(!$input_data_list && array_key_exists(2, $argv) && ($argv[2] == 'list' || $argv[2] == 'one')) {
        if($input_name !== 'input-*.txt') { $input_name = 'input-*.txt'; }
        $input_path = fileUtil::create_path($current_dir, $target_name, $input_name);
        $input_data_list = fileUtil::get_data_list($input_path);
        if(!$input_data_list) {
            throw new Exception("Can't find input file list.\n{$input_path}", 3);
        }
    }
    $input_data_count = count($input_data_list);

    // get check data file path
    if(array_key_exists(3, $argv)) {
        $check_name = $argv[3];
    } else {
        $check_name = 'check-*.txt';
    }
    $check_path = fileUtil::create_path($current_dir, $target_name, $check_name);
    $check_data_list = fileUtil::get_data_list($check_path);
    if(!$check_data_list) {
        throw new Exception("Can't find check file list.".PHP_EOL."{$check_path}", 5);
    }
    $check_data_count = count($check_data_list);

    // construct processUtil
    $processUtil = new processUtil($target_path);

    if($input_data_count !== $check_data_count) {
        echo 'Warning: Is deferrent number of input files and check files.', PHP_EOL;
    }

    $c1 = 1;
    array_map(function($input_list, $check_list) use($argv, $processUtil, &$c1) {
        $input_count = count($input_list);
        $check_count = count($check_list);
        $output_list = [];

        $display_input = array_map(function($v) {
            return str_replace(["\r", "\n"], ["[cr]", "[lf]"], $v);
        }, $input_list);

        if((array_key_exists(2, $argv) && $argv[2] === 'list')) {
            echo $c1, ': input io_list : ', print_r($display_input, true), PHP_EOL;
            $output_list = $processUtil->io_list($input_list);
        } else
        if((array_key_exists(2, $argv) && $argv[2] === 'one')) {
            echo $c1, ': input io_one  :', PHP_EOL;
            foreach($display_input as $input_one) { echo $c1, ': input : ', $input_one, PHP_EOL; }
            $output_list = $processUtil->io_one($input_list);
        } else
        if($input_count === $check_count) {
            echo $c1, ': input io_one  :', PHP_EOL;
            foreach($display_input as $input_one) { echo $c1, ': input : ', $input_one, PHP_EOL; }
            $output_list = $processUtil->io_one($input_list);
        } else {
            echo $c1, ': input io_list  : ', print_r($display_input, true), PHP_EOL;
            $output_list = $processUtil->io_list($input_list);
        }

        $c2 = 1;
        array_map(function($check, $output) use(&$c1, &$c2) {
            if(false !== strpos($output, "\r") || false !== strpos($output, "\n")) {
                $check = str_replace("\r", '[cr]', $check);
                $check = str_replace("\n", '[lf]', $check);
                $output = str_replace("\r", '[cr]', $output);
                $output = str_replace("\n", '[lf]', $output);
            } else {
                $check = str_replace("\r", '', $check);
                $check = str_replace("\n", '', $check);
            }
            echo $c1, '-', $c2, ': check  : ', print_r($check, true), PHP_EOL;
            echo $c1, '-', $c2, ': output : ', print_r($output, true), PHP_EOL;
            ++$c2;
            if($check === $output ||
                (0 === strcasecmp('null',  $check) && is_null($output)) ||
                (0 === strcasecmp('true',  $check) && is_bool($check) &&  $check) ||
                (0 === strcasecmp('false', $check) && is_bool($check) && !$check)
                ) {
                echo '    true', PHP_EOL;
                return;
            }
            echo '    false', PHP_EOL;
        }, $check_list, $output_list);
        ++$c1;

    }, $input_data_list, $check_data_list);

});
