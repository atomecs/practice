<?php
include 'dataBase.php';
if (isset($_POST['submit'])) {
    $delete = $_POST['delete'];
    if (empty($delete)) {
        die("Please, input all values!");
    }
    try {
        $connect->beginTransaction();

        $query = "DELETE FROM users_tasks WHERE tasks_id = ?";
        $stmt = $connect->prepare($query);
        $stmt->execute(array($delete));

        $query = "DELETE FROM tasks WHERE id = ?";
        $stmt = $connect->prepare($query);
        $stmt->execute(array($delete));

        $connect->commit();
    } catch (PDOException $e) {
        $e->getMessage();
        $connect->rollBack();
    }

}
header('Location: deleteTasks.php');
exit;
?>
