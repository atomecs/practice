<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once __DIR__.'/bootstrap.php';

$entityManager = GetEntityManager($dbParams);

return ConsoleRunner::createHelperSet($entityManager);
