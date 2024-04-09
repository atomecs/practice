<?php

namespace service;

use PDO;
use PDOException;

class TaskService
{

    public $connect;

    public function __construct()
    {
        require_once "./config/dataBase.php";
        $this->connect = $connect;
    }

    public function getPage($route)
    {
        if (file_exists($route)) {
            return require_once $route;
        } else {
            return "not found";
        }
    }

    public function printTasks()
    {
        $res = "SELECT ut.tasks_id, t.describe, t.dedline, p.prioritet, u.fio
        FROM users_tasks ut
        JOIN tasks t ON ut.tasks_id = t.id
        JOIN prioritets p ON t.fk_prioritet = p.id
        JOIN users u ON u.id = ut.users_id";
        $stmt = $this->connect->query($res);
        return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function createTask($taskDto, $userDto)
    {
        try {
            $this->connect->beginTransaction();
            $query = "INSERT INTO tasks (describe, dedline, fk_prioritet) VALUES (?,
?, ?)";
            $stmt = $this->connect->prepare($query);
            $stmt->execute(array($taskDto->describe, $taskDto->deadline, $taskDto->prioritetId));

            $taskDto->id = $this->connect->lastInsertId();
            foreach ($userDto->id as $uId) {
                $query2 = "INSERT INTO users_tasks (users_id, tasks_id)VALUES(?,?)";
                $stmt2 = $this->connect->prepare($query2);
                $stmt2->execute(array($uId, $taskDto->id));
            }
            $this->connect->commit();
            echo "Completed";
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            $this->connect->rollBack();


        }


    }

    public function editTask($taskDto, $userDto)
    {
        try {
            $this->connect->beginTransaction();

            $query = "DELETE FROM users_tasks WHERE tasks_id = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->execute(array($taskDto->id));


            $query2 = "UPDATE tasks SET describe=?, dedline = ?, fk_prioritet = ? WHERE id=?";
            $stmt = $this->connect->prepare($query2);
            $stmt->execute(array($taskDto->describe, $taskDto->deadline, $taskDto->prioritetId, $taskDto->id));

            foreach ($userDto->id as $uId) {
                $query2 = "INSERT INTO users_tasks (users_id, tasks_id)VALUES(?,?)";
                $stmt2 = $this->connect->prepare($query2);
                $stmt2->execute(array($uId, $taskDto->id));
            }

            $this->connect->commit();
            echo "Completed";
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            $this->connect->rollBack();
        }
    }

    public function deleteTask($taskDto)
    {
        try {
            $this->connect->beginTransaction();

            $query = "DELETE FROM users_tasks WHERE tasks_id = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->execute(array($taskDto->id));

            $query = "DELETE FROM tasks WHERE id = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->execute(array($taskDto->id));

            $this->connect->commit();
            echo "Completed";
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            $this->connect->rollBack();
        }
    }
}