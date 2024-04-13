<?php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once "vendor/autoload.php";

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__."/src"),
    isDevMode: true,
);
// or if you prefer XML
// $config = ORMSetup::createXMLMetadataConfiguration(
//    paths: array(__DIR__."/config/xml"),
//    isDevMode: true,
//);

// configuring the database connection
$connection = DriverManager::getConnection([
    'driver' => 'pdo_pgsql',
    'user' => 'postgres',
    'password' => 'daniil2018',
    'host' => 'localhost',
    'port' => '5432',
    'dbname' => 'train',
], $config);

// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);