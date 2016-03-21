<?php

class processUtil {

    protected $process;
    protected $descriptorspec= [
        ['pipe', 'r'], // stdin
        ['pipe', 'w'], // stdout
        ['file', __DIR__.'/proc-open-error.log', 'a'], // stderr
    ];
    protected $pipes = [];
    protected $cwd = null;
    protected $env = null;

    const in = 0;
    const out = 1;
    const blogsize = 4096;

    function __construct($target_path = '') {
        if($target_path) { $this->target_path = $target_path; }
    }

    function open($target_path = '') {
        if(!$target_path) { $target_path = $this->target_path; }
        if(!is_file($target_path)) {
            throw new Exception("Failed to open target file : $target_path", 1);
        }
        $this->process = proc_open('php '.$target_path, $this->descriptorspec, $this->pipes, $this->cwd, $this->env);
        stream_set_blocking($this->pipes[self::in], true);
        stream_set_blocking($this->pipes[self::out], true);
        return $this->process;
    }

    function close() {
        if(!$this->process) { return true; }
        if(!($this->pipes[self::in])) { throw new Exception("Error Processing Request", 1); }
        if(!($this->pipes[self::out])) { throw new Exception("Error Processing Request", 2); }
        return proc_close($this->process);
    }

    function io($write_data_list) {
        $output = '';
        $write = implode('', $write_data_list);
        fwrite($this->pipes[self::in], $write.PHP_EOL);
        fclose($this->pipes[self::in]);
        while(!feof($this->pipes[self::out])) {
            $read = fread($this->pipes[self::out], self::blogsize);
            if($read) {
                $output .= $read;
            }
        }
        fclose($this->pipes[self::out]);
        return $output;
    }

    /**
     * function io_list
     *
     * input list
     *   input list
     *   output one
     * output one
     *
     */
    function io_list($input_data_list) {
        if(!$input_data_list && !is_array($input_data_list)) {
            throw new Exception(__CLASS__.": input data list is empty.", 11);
        }
        $this->open();
        $output = $this->io($input_data_list);
        $output = str_replace(["\r", "\n"], ["@[cr]\r", "@[lf]\n"], $output);
        $output_data_list = preg_split('/[\r\n]+/', $output);
        array_pop($output_data_list);
        $output_data_list = array_map(function($val) {
            return str_replace(['@[cr]', '@[lf]'], ["\r", "\n"], $val);
        }, $output_data_list);
        $this->close();
        return $output_data_list;
    }

    /**
     * function io_one
     *
     * input list
     *   input one
     *   output one
     * output list
     *
     */
    function io_one($input_data_list) {
        if(!$input_data_list && !is_array($input_data_list)) {
            throw new Exception(__CLASS__.": input data list is empty.", 11);
        }
        $output_data_list = array_map(function($val) {
            $this->open();
            if(is_array($val)) {
                $r = $this->io($val);
            } else {
                $r = $this->io([$val]);
            }
            $this->close();
            return $r;
        }, $input_data_list);
        return $output_data_list;
    }

}
