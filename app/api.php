<?php

use app\Entities\PrioritetEntity;

require_once 'bootstrap.php';


$entityManager = getEntityManager();
$class = $_GET['act'] ?? '0';
$method = $_GET['method'] ?? '0';
$Class = 'app\\controllers\\' . ucfirst($class) . 'Controller';
$Controller = new $Class($entityManager);
echo $Controller->$method($_REQUEST);




