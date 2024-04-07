<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

function debug($str)
{
    echo '<pre>';
    var_dump($str);
    echo '</pre>';
    exit;
}
use controllers\UserController;
use controllers\TaskController;
use service\TaskService;
use service\UserService;

spl_autoload_register(function ($class) {
    $patch = str_replace('\\', '/', $class.'.php');
    if (file_exists($patch)) {
        require_once $patch;
    }
});
$class = $_GET['act']??'0';
$method = $_GET['method']??'0';

switch ($class) {
    case 'user':
        $Controller = new UserController();
        echo $Controller->$method();
        break;
    case 'task':
        $Controller = new TaskController();
        echo $Controller->$method();
        break;

    default:
        echo "not found";
        break;
}




