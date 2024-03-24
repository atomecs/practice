<?php
include 'dataBase.php';
$res = "SELECT ut.tasks_id, t.describe, t.dedline, p.prioritet, u.fio
        FROM users_tasks ut
        JOIN tasks t ON ut.tasks_id = t.id
        JOIN prioritets p ON t.fk_prioritet = p.id
        JOIN users u ON u.id = ut.users_id";
$stmt = $connect->query($res);
echo "<table><tr><th>Id</th><th>Describe</th><th>Dedline</th><th>Prioritet</th><th>User</th></tr>";
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $beginValue) {
    foreach ($beginValue as $key => $value) {
        echo "<td>" . $value . "</td>";
        if ($key == 'tasks_id') {
            $printKey = $value;
        }
    }
    echo "<td><input type='checkbox' name='delete' value=$printKey> Delete</td>";
    echo "</tr>";
}

echo "</table>";
?>
