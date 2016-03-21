<?php
require dirname(__DIR__). '/pppt_lib/autoload.php';

class processUtilTest extends PHPUnit_Framework_TestCase
{
    protected $target = null;

    function setUp() {
        if(!$this->target) {
            $exec = dirname(__DIR__).'/pppt_test/answer.php';
            $this->target = new processUtil($exec);
        }
    }

    function test_open_close() {
        $output_open = $this->target->open();
        $output_close = $this->target->close();
        $this->assertTrue(1 === preg_match('/^Resource id #\d+$/', (string)$output_open));
        $this->assertTrue(0 <= $output_close);
    }

    function test_io() {
        $input = ['stream test'];
        $check = "stream test\n";
        $output_open = $this->target->open();
        $output_io = $this->target->io($input);
        $output_close = $this->target->close();
        $this->assertTrue(1 === preg_match('/^Resource id #\d+$/', (string)$output_open));
        $this->assertEquals($check, $output_io);
        $this->assertTrue(0 <= $output_close);

        $input = ["3", "aaa", "bbb", "ccc"];
        $check = "aaa && bbb && ccc\n";
        $output_open = $this->target->open();
        $output_io = $this->target->io($input);
        $output_close = $this->target->close();
        $this->assertTrue(1 === preg_match('/^Resource id #\d+$/', (string)$output_open));
        $this->assertEquals($check, $output_io);
        $this->assertTrue(0 <= $output_close);
    }

    function test_io_list() {
        $input = ["3", "aaa", "bbb", "ccc"];
        $check = ["aaa && bbb && ccc\n"];
        $output = $this->target->io_list($input);
        $this->assertEquals($check, $output);

        $input = ["aaa", "bbb", "ccc"];
        $check = ["aaa\n"];
        $output = $this->target->io_list($input);
        $this->assertEquals($check, $output);
    }

    function test_io_one() {
        $input = ["aaa", "bbb", "ccc"];
        $check = ["aaa\n", "bbb\n", "ccc\n"];
        $output = $this->target->io_one($input);
        $this->assertEquals($check, $output);

        /*
            // This input dont assume.
            // fread will continue to wait forever.
        $input = ["3", "aaa", "bbb", "ccc"];
        $check = ["aaa\n", "bbb\n", "ccc\n"];
        $output = $this->target->io_one($input);
        $this->assertEquals($check, $output);
        */
    }

}