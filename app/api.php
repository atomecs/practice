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
$class = $_GET['act']??'0';
$method = $_GET['method']??'0';

switch ($class) {
    case 'user':
        require_once "./controllers/UserController.php";
        $Controller = new UserController();
        echo $Controller->$method();
        break;
    case 'task':
        require_once "./controllers/TaskController.php";
        $Controller = new TaskController();
        echo $Controller->$method();
        break;

    default:
        echo "not found";
        break;
}




