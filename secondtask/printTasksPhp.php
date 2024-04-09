<?php
include 'dataBase.php';
$res = "SELECT ut.tasks_id, t.describe, t.dedline, p.prioritet, u.fio
        FROM users_tasks ut
        JOIN tasks t ON ut.tasks_id = t.id
        JOIN prioritets p ON t.fk_prioritet = p.id
        JOIN users u ON u.id = ut.users_id";
$stmt = $connect->query($res);
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $beginValue) {
    var_dump($beginValue);
}
?>
