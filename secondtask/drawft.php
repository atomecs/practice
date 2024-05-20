<?php
include 'dataBase.php';
$res = "SELECT * FROM users";
$stmt = $connect->query($res);
echo "<table><tr><th>Id</th><th>Имя</th></tr>";
$i = 1;
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $val) {
    var_dump($val);
    foreach ($val as $key => $value) {
        echo "<td>" . $value . "</td>";
        if ($key == 'id') {
            $ke = $value;
        }

    }
    echo "<td><input type='checkbox' name='delete' value=$ke> Delete</td>";

    echo "</tr>";
}

echo "</table>";
?>
