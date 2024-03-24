<?php
include 'dataBase.php';
$result = "SELECT * FROM users";
$stmt = $connect->query($result);
echo "<table><tr><th>Id</th><th>Имя</th></tr>";
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $value) {
    if ($value['id'] != 66){
        echo "<td>" . $value['id'] . "</td>";
        echo "<td>" . $value['fio'] . "</td>";
        $key = $value['id'];
        echo "<td><input type='checkbox' name='delete' value=$key> Delete</td>";
        echo "</tr>";
    }

}

echo "</table>";
?>
