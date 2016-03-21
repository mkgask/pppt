<?php
spl_autoload_register(function ($class_name) {
    $path = __DIR__. '/'. $class_name . '.php';
    if(is_file($path)) {
        require $path;
    }
});