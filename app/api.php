<?php
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

echo PHP_VERSION_ID;
spl_autoload_register(function ($class) {
    $patch = str_replace('\\', '/', $class . '.php');
    if (file_exists($patch)) {
        require_once $patch;
    }
});

$entityManager = getEntityManager();
$product = $entityManager->getRepository('TaskEntity')->findOneBy(['id' => 85]);
var_dump($product);
$class = $_GET['act'] ?? '0';
$method = $_GET['method'] ?? '0';
$Class = 'app\\controllers\\' . ucfirst($class) . 'Controller';
$Controller = new $Class;
echo $Controller->$method($_REQUEST);




