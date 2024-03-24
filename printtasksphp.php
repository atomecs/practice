<?php
include 'db.php';
$res = "SELECT ut.tasks_id, t.describe, t.dedline, p.prioritet, u.fio
        FROM users_tasks ut
        JOIN tasks t ON ut.tasks_id = t.id
        JOIN prioritets p ON t.fk_prioritet = p.id
        JOIN users u ON u.id = ut.users_id";
$stmt = $cn->query($res);
echo "<table><tr><th>Id</th><th>Describe</th><th>Dedline</th><th>Prioritet</th><th>User</th></tr>";
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $val) {
    foreach ($val as $key => $value) {
        echo "<td>" . $value . "</td>";
        if ($key == 'tasks_id') {
            $ke = $value;
        }
    }
    echo "<td><input type='checkbox' name='delete' value=$ke> Delete</td>";
    echo "</tr>";
}

echo "</table>";
?>
