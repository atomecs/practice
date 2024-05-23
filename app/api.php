<?php

require_once __DIR__.'/bootstrap.php';
register_shutdown_function(function (){var_dump(error_get_last()); die();});

$entityManager = getEntityManager($dbParams);
$class = $_GET['act'] ?? sendFailure('метода не существует');
$method = $_GET['method'] ?? sendFailure('запроса не существует');
$class = 'app\\controllers\\' . ucfirst($class) . 'Controller';
$controller = new $class($entityManager);
$response = $controller->$method($_REQUEST);
echo json_encode([
    'success'=>true,
    'rows'=>$response
]);




