<?php
$dbhost = 'localhost';
$dbname = 'train';
$dbuser = 'postgres';
$dbpassword = 'daniil2018';
$cn = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
if (isset($_POST['submit'])) {
    $delete = $_POST['delete'];
    echo $delete;
    if (!$delete){
        die("Please, input all values!");
    }
    $query = "DELETE FROM users_tasks WHERE tasks_id = ?";
    $stmt = $cn->prepare($query);
    $stmt->execute(array($delete));
    $query = "DELETE FROM tasks WHERE id = ?";
    $stmt = $cn->prepare($query);
    $stmt->execute(array($delete));
}
header('Location: tasks.php');
exit;
?>
