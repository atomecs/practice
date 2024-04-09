<?php
include 'dataBase.php';
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $describe = $_POST['describe'];
    $deadline = $_POST['deadline'];
    $prioritetId = $_POST['prioritet'];
    $userId1 = $_POST['user1'];
    $userId2 = $_POST['user2'];
    if (empty($describe) || empty($deadline) || empty($prioritetId) || empty($userId1) || empty($userId2)) {
        die("Please, input all values!");
    }

    try {
        $connect->beginTransaction();

        $query = "DELETE FROM users_tasks WHERE tasks_id = ?";
        $stmt = $connect->prepare($query);
        $stmt->execute(array($id));


        $query2 = "UPDATE tasks SET describe=?, dedline = ?, fk_prioritet = ?, fk_tasks_users = ? WHERE id=?";
        $stmt = $connect->prepare($query2);
        $stmt->execute(array($describe, $deadline, $prioritetId, $userId1, $id));

        $query3 = "INSERT INTO users_tasks (users_id, tasks_id)VALUES(?,?)";
        $stmt2 = $connect->prepare($query3);
        $stmt2->execute(array($userId1, $id));

        $query4 = "INSERT INTO users_tasks (users_id, tasks_id)VALUES(?,?)";
        $stmt4 = $connect->prepare($query4);
        $stmt4->execute(array($userId2, $id));

        $connect->commit();
    } catch (PDOException $e) {
        $e->getMessage();
        $connect->rollBack();
    }


}
header('Location: editTasks.php');
exit;
?>