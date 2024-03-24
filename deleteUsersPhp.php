<?php
include 'dataBase.php';
if (isset($_POST['submit'])) {
    $delete = $_POST['delete'];
    if (empty($delete)) {
        die("Please, input all
values!");
    }
    try {
        $connect->beginTransaction();

        $query = "DELETE FROM users_tasks WHERE users_id = ?";
        $stmt = $connect->prepare($query);
        $stmt->execute(array($delete));

        $query1 = "UPDATE tasks SET fk_tasks_users = 66 WHERE fk_tasks_users=?";
        $stmt = $connect->prepare($query1);
        $stmt->execute(array($delete));

        $query2 = "DELETE FROM users WHERE id = ?";
        $stmt2 = $connect->prepare($query2);
        $stmt2->execute(array($delete));

        $connect->commit();
    } catch (PDOException $e) {
        echo $e->getMessage();
        $connect->rollBack();
    }

}
header('Location: users.php');
exit;
?>