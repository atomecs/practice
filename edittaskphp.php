<?php
$dbhost = 'localhost';
$dbname = 'train';
$dbuser = 'postgres';
$dbpassword = 'daniil2018';
$cn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $describe = $_POST['describe'];
    $deadline = $_POST['deadline'];
    $select1 = $_POST['select1'];
    $select2 = $_POST['select2'];
    if (!$describe || !$deadline|| !$select1 || !$select2){
        die("Please, input all values!");
    }
    echo $id;
    $query = "UPDATE users_tasks SET users_id=? WHERE id=?";
    $stmt = $cn->prepare($query);
    $stmt->execute(array($select2,$id));

    $query = "UPDATE tasks SET describe=?, dedline = ?, fk_prioritet = (SELECT id FROM prioritets WHERE prioritet = ?), fk_tasks_users = (SELECT id FROM users WHERE fio = ?) WHERE id=?";
    $stmt = $cn->prepare($query);
    $stmt->execute(array($describe,$deadline,$select1,$select2,$id));
}
header('Location: etasks.php');
exit;
?>