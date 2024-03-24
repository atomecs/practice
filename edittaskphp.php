<?php
include 'db.php';
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $describe = $_POST['describe'];
    $deadline = $_POST['deadline'];
    $prioritetID = $_POST['prioritet'];
    $userID1 = $_POST['user1'];
    $userID2 = $_POST['user2'];
    if (empty($describe) || empty($deadline) || empty($prioritetID) || empty($userID1) || empty($userID2)) {
        die("Please, input all values!");
    }

    try {
        $cn->beginTransaction();

        $query = "DELETE FROM users_tasks WHERE tasks_id = ?";
        $stmt = $cn->prepare($query);
        $stmt->execute(array($id));


        $query2 = "UPDATE tasks SET describe=?, dedline = ?, fk_prioritet = ?, fk_tasks_users = ? WHERE id=?";
        $stmt = $cn->prepare($query2);
        $stmt->execute(array($describe, $deadline, $prioritetID, $userID1, $id));

        $query3 = "INSERT INTO users_tasks (users_id, tasks_id)VALUES(?,?)";
        $stmt2 = $cn->prepare($query3);
        $stmt2->execute(array($userID1, $id));

        $query4 = "INSERT INTO users_tasks (users_id, tasks_id)VALUES(?,?)";
        $stmt4 = $cn->prepare($query4);
        $stmt4->execute(array($userID2, $id));

        $cn->commit();
    } catch (PDOException $e) {
        $e->getMessage();
        $cn->rollBack();
    }


}
header('Location: edittasks.php');
exit;
?>