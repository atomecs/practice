<?php
include 'dataBase.php';
$result = "SELECT * FROM users";
$stmt = $connect->query($result);

foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $value) {
    var_dump($value);
}

?>
