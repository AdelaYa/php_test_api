<?php

session_start();
use Core\BaseController;


spl_autoload_register(function ($class) {
    $file = 'mvc' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    return false;
});


$baseController = new BaseController();
$baseController->processRequest();