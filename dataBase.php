<?php
$dataBaseHost = 'localhost';
$dataBaseName = 'train';
$dataBaseUser = 'postgres';
$dataBasePassword = 'daniil2018';
$port = '5432';
$connect = new PDO("pgsql:host=$dataBaseHost;dbname=$dataBaseName;port=$port;", $dataBaseUser, $dataBasePassword);