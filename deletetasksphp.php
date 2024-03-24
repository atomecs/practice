<?php
include 'db.php';
if (isset($_POST['submit'])) {
    $delete = $_POST['delete'];
    if (empty($delete)) {
        die("Please, input all values!");
    }
    try {
        $cn->beginTransaction();
        $query = "DELETE FROM users_tasks WHERE tasks_id = ?";
        $stmt = $cn->prepare($query);
        $stmt->execute(array($delete));
        $query = "DELETE FROM tasks WHERE id = ?";
        $stmt = $cn->prepare($query);
        $stmt->execute(array($delete));
        $cn->commit();
    } catch (PDOException $e) {
        $e->getMessage();
        $cn->rollBack();
    }

}
header('Location: tasks.php');
exit;
?>
