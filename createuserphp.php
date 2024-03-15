<?php

$dbhost = 'localhost';
$dbname = 'train';
$dbuser = 'postgres';
$dbpassword = 'daniil2018';
$cn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);


if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    if (!$username){
        die("Please, input all
values!");
    }
    $query = "INSERT INTO users(fio) 
	 values (?)";
    $stmt = $cn->prepare($query);
    $stmt->execute(array($username));
}
header('Location: cuser.php');
exit;
