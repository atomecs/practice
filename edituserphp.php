<?php
include 'db.php';
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    if (isset($username)) {
        die("Please, input all
values!");
    }

    $query = "UPDATE users SET fio=? WHERE id=?";
    $stmt = $cn->prepare($query);
    $stmt->execute(array($username, $id));

}
header('Location: editusers.php');
exit;