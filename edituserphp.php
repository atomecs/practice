<?php

$dbhost = 'localhost';
$dbname = 'train';
$dbuser = 'postgres';
$dbpassword = 'daniil2018';
$cn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    if (!$username){
        die("Please, input all
values!");
    }
    echo $id;
    $query = "UPDATE users SET fio=? WHERE id=?";
    $stmt = $cn->prepare($query);
    $stmt->execute(array($username,$id));

}
header('Location: eusers.php');
exit;