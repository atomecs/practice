<?php

require_once 'bootstrap.php';
//register_shutdown_function(function (){var_dump(error_get_last()); die();});


$entityManager = getEntityManager();
$class = $_GET['act'] ?? '0';
$method = $_GET['method'] ?? '0';
$class = 'app\\controllers\\' . ucfirst($class) . 'Controller';
$controller = new $class($entityManager);
$response = $controller->$method($_REQUEST);
echo json_encode(['success'=>true, 'rows'=>$response]);




