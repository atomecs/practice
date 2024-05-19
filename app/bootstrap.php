<?php


use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

require_once "vendor/autoload.php";

function sendFailure($e): void
{
    echo json_encode(['success'=>false, 'rows'=>$e]);
    die;
}

function getEntityManager(): EntityManager
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


    $connectionOptions = $dbParams = array(
        'driver' => 'pdo_pgsql',
        'user' => 'postgres',
        'password' => 'daniil2018',
        'host' => 'localhost',
        'dbname' => 'train',
    );

    return EntityManager::create($connectionOptions, $config);
}