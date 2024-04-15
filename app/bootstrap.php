<?php

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\DBAL\DriverManager;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

require_once "vendor/autoload.php";


function getEntityManager(): EntityManager
{
    $config = new Configuration;

    $queryCache = new ArrayAdapter();
    $metadataCache = new ArrayAdapter();

    $config->setMetadataCache($metadataCache);
    $config->setQueryCache($queryCache);

    //annotations driver
    $driver = new AnnotationDriver(new AnnotationReader(), [__DIR__ . '/Entities']);
    $config->setMetadataDriverImpl($driver);

    //proxy config
    $config->setProxyDir(__DIR__ . '/var/cache');
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