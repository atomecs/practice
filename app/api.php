<?php

use app\Entities\PrioritetEntity;

require_once 'bootstrap.php';


$entityManager = getEntityManager();
$class = $_GET['act'] ?? '0';
$method = $_GET['method'] ?? '0';
$class = 'app\\controllers\\' . ucfirst($class) . 'Controller';
$controller = new $class($entityManager);
echo json_encode($controller->$method($_REQUEST));




