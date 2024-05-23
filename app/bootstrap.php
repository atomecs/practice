<?php


use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

require_once __DIR__."/vendor/autoload.php";
require_once __DIR__.'/secret.php';

function sendFailure($e): void
{
    echo json_encode([
        'success'=>false,
        'rows'=>$e
    ]);
    exit();
}

function getEntityManager(array $dbParams): EntityManager
{

    $config = new Configuration;

    $queryCache = new ArrayAdapter();
    $metadataCache = new ArrayAdapter();

    $config->setMetadataCache($metadataCache);
    $config->setQueryCache($queryCache);

    //annotations driver
    $driver = new AttributeDriver( [__DIR__ . '/Entities']);
    $config->setMetadataDriverImpl($driver);

    //proxy config
    $config->setProxyDir(__DIR__. '/var/cache');
    $config->setProxyNamespace('Cache\Proxies');
    $config->setAutoGenerateProxyClasses(false);


    $connectionOptions = $dbParams;

    return EntityManager::create($connectionOptions, $config);
}