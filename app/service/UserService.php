<?php

namespace app\service;

use PDO;
use PDOException;
use app\Entities\UserEntity;

class UserService
{

    public $connect;

    public function __construct()
    {
//        require_once "./config/dataBase.php";
//        $this->connect = $connect;
    }

    public function getPage($route)
    {
        if (file_exists($route)) {
            return require_once $route;
        } else {
            return "not found";
        }
    }

    public function printUsers()
    {
        $entityManager= getEntityManager();
        $product = $entityManager->getRepository('UserEntity')->findOneBy(['id' => 85]);
//        $result = "SELECT * FROM users";
//        $stmt = $this->connect->query($result);
        return $product;
    }

    public function createUser($userDto)
    {
        var_dump($userDto);
        try {
            $query = "INSERT INTO users(fio) values (?)";
            $stmt = $this->connect->prepare($query);
            $stmt->execute(array($userDto->username));
            return "Completed";
        } catch (PDOException $e) {
            return $e->getMessage();
        }


    }

    public function editUser($userDto)
    {
        try {
            $query = "UPDATE users SET fio=? WHERE id=?";
            $stmt = $this->connect->prepare($query);
            $stmt->execute(array($userDto->username, $userDto->id));
            return "Completed";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteUser($userDto)
    {
        try {
            $this->connect->beginTransaction();

            $query = "DELETE FROM users_tasks WHERE users_id = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->execute(array($userDto->id));


            $query2 = "DELETE FROM users WHERE id = ?";
            $stmt2 = $this->connect->prepare($query2);
            $stmt2->execute(array($userDto->id));

            $this->connect->commit();
            return "Completed";
        } catch (PDOException $e) {
            $this->connect->rollBack();
            return $e->getMessage();

        }
    }
}