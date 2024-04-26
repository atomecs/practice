<?php

use app\Entities\PrioritetEntity;

require_once 'bootstrap.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);



function debug($str)
{
    echo '<pre>';
    var_dump($str);
    echo '</pre>';
    exit;
}


$entityManager = getEntityManager();
$class = $_GET['act'] ?? '0';
$method = $_GET['method'] ?? '0';
$Class = 'app\\controllers\\' . ucfirst($class) . 'Controller';
$Controller = new $Class($entityManager);
//$Controller = new \app\controllers\UserController($entityManager);
//echo $Controller->getPage('createTask');
echo json_encode($Controller->$method($_REQUEST));




