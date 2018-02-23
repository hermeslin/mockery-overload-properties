<?php
error_reporting(E_ALL);
require_once dirname(__DIR__) . '/vendor/autoload.php';

// use spl_autoload_register to register our example class
// it can prevent "Could not load mock some class, class already exists" error when you use Mockery to mock your legacy class
spl_autoload_register(
    function ($class) {
        $fileName = dirname(__DIR__) . '/example/' . $class . '.php';
        if (file_exists($fileName)) {
            include_once $fileName;
        }
    }
);