<?php

class TaskService
{

    public $connect;

    public function __construct()
    {
        require_once "./config/dataBase.php";
        $this->connect = $connect;
    }
    public function givePage($route)
    {
        if (file_exists($route)){
            return require_once $route;
        }
        else {
            return "not found";
        }
    }

    public function printAll()
    {
        $res = "SELECT ut.tasks_id, t.describe, t.dedline, p.prioritet, u.fio
        FROM users_tasks ut
        JOIN tasks t ON ut.tasks_id = t.id
        JOIN prioritets p ON t.fk_prioritet = p.id
        JOIN users u ON u.id = ut.users_id";
        $stmt = $this->connect->query($res);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createQuery($describe, $deadline, $prioritetId, $userId1, $userId2)
    {
        try {
            $this->connect->beginTransaction();
            $query = "INSERT INTO tasks (describe, dedline, fk_prioritet) VALUES (?,
?, ?)";
            $stmt = $this->connect->prepare($query);
            $stmt->execute(array($describe, $deadline, $prioritetId,));

            $id = $this->connect->lastInsertId();

            $query2 = "INSERT INTO users_tasks (users_id, tasks_id)VALUES(?,?)";
            $stmt2 = $this->connect->prepare($query2);
            $stmt2->execute(array($userId1, $id));

            $query3 = "INSERT INTO users_tasks (users_id, tasks_id)VALUES(?,?)";
            $stmt3 = $this->connect->prepare($query3);
            $stmt3->execute(array($userId2, $id));
            $this->connect->commit();
            echo "Completed";
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            $this->connect->rollBack();


        }


    }

    public function editQuery($id, $describe, $deadline, $prioritetId, $userId1, $userId2)
    {
        try {
            $this->connect->beginTransaction();

            $query = "DELETE FROM users_tasks WHERE tasks_id = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->execute(array($id));


            $query2 = "UPDATE tasks SET describe=?, dedline = ?, fk_prioritet = ? WHERE id=?";
            $stmt = $this->connect->prepare($query2);
            $stmt->execute(array($describe, $deadline, $prioritetId, $id));

            $query3 = "INSERT INTO users_tasks (users_id, tasks_id)VALUES(?,?)";
            $stmt2 = $this->connect->prepare($query3);
            $stmt2->execute(array($userId1, $id));

            $query4 = "INSERT INTO users_tasks (users_id, tasks_id)VALUES(?,?)";
            $stmt4 = $this->connect->prepare($query4);
            $stmt4->execute(array($userId2, $id));

            $this->connect->commit();
            echo "Completed";
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            $this->connect->rollBack();
        }
    }
    public function deleteQuery($delete)
    {
        try {
            $this->connect->beginTransaction();

            $query = "DELETE FROM users_tasks WHERE tasks_id = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->execute(array($delete));

            $query = "DELETE FROM tasks WHERE id = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->execute(array($delete));

            $this->connect->commit();
            echo "Completed";
        } catch (PDOException $e) {
            $e->getMessage();
            $this->connect->rollBack();
        }
    }
}