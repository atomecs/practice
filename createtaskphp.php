<?php
$dbhost = 'localhost';
$dbname = 'train';
$dbuser = 'postgres';
$dbpassword = 'daniil2018';
$cn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
if (isset($_POST['submit'])) {
    $describe = $_POST['describe'];
    $deadline = $_POST['deadline'];
    $select1 = $_POST['select1'];
    $select2 = $_POST['select2'];
    $select3 = $_POST['select3'];
    if (!$describe || !$deadline|| !$select1 || !$select2){
        die("Please, input all values!");
    }
    $query = "INSERT INTO tasks (describe, dedline, fk_prioritet, fk_tasks_users ) VALUES (?,
?, (SELECT id FROM prioritets WHERE prioritet = ?), (SELECT id FROM users WHERE fio = ?))";
    $stmt = $cn->prepare($query);
    $stmt->execute(array($describe,$deadline,$select1,$select2));

    $query1 = "SELECT id FROM tasks WHERE describe = ?";
    $stmt1 = $cn->prepare($query1);
    $stmt1->execute(array($describe));
    $ids = $stmt1 -> fetch();
    $id = $ids["id"];

    $query2 = "INSERT INTO users_tasks (users_id, tasks_id)VALUES((SELECT id FROM users WHERE fio = ?),?)";
    $stmt2 = $cn->prepare($query2);
    $stmt2->execute(array($select2,$id));

    $query3 = "SELECT id FROM tasks WHERE describe = ?";
    $stmt3 = $cn->prepare($query1);
    $stmt3->execute(array($describe));
    $ids = $stmt3 -> fetch();
    $id = $ids["id"];

    $query4 = "INSERT INTO users_tasks (users_id, tasks_id)VALUES((SELECT id FROM users WHERE fio = ?),?)";
    $stmt4 = $cn->prepare($query3);
    $stmt4->execute(array($select3,$id));
}
header('Location: ctask.php');
exit;
?>
