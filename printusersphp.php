<?php
include 'db.php';
$res = "SELECT * FROM users";
$stmt = $cn->query($res);
echo "<table><tr><th>Id</th><th>Имя</th></tr>";
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $val) {
    if ($val['id'] != 66){
        echo "<td>" . $val['id'] . "</td>";
        echo "<td>" . $val['fio'] . "</td>";
        $key = $val['id'];
        echo "<td><input type='checkbox' name='delete' value=$key> Delete</td>";
        echo "</tr>";
    }

}

echo "</table>";
?>
