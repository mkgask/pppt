<?php
require dirname(__DIR__). '/pppt_lib/autoload.php';

class fileUtilTest extends PHPUnit_Framework_TestCase
{

    function test_create_path() {
        $input1 = '/vagrant';
        $input2 = 'vendor';
        $input3 = 'bin';
        $input4 = 'composer';
        $check = $input1. '/'. $input2. '/'. $input3. '/'. $input4;
        $output = fileUtil::create_path($input1, $input2, $input3, $input4);
        $this->assertEquals($check, $output);

        $input1 = './pppt_test';
        $input2 = 'answer.php';
        $check = $input1. '/'. $input2;
        $output = fileUtil::create_path($input1, $input2);
        $this->assertEquals($check, $output);
    }

    function test_get_data_list() {
        $input = dirname(__DIR__).'/pppt_test/input-*.txt';
        $check[] = file(dirname(__DIR__).'/pppt_test/input-1.txt');
        $output = fileUtil::get_data_list($input);
        $this->assertEquals($check, $output);
    }

}