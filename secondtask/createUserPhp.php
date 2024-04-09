<?php
include 'dataBase.php';
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    echo $username;
    if (empty($username)) {
        die("Please, input all
values!");
    }
    $query = "INSERT INTO users(fio) 
	 values (?)";
    $stmt = $connect->prepare($query);
    $stmt->execute(array($username));
}
header('Location: createUser.php');
exit;
