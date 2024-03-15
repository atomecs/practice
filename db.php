<?php
    $dbhost = 'localhost';
    $dbname = 'train';
    $dbuser = 'postgres';
    $dbpassword = 'daniil2018';
    $port = '5432';
    $cn = new PDO("pgsql:host=$dbhost;dbname=$dbname;port=$port;", $dbuser, $dbpassword);