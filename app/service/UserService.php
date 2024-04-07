<?php
namespace service;
use PDO;
use PDOException;

class UserService
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
        $result = "SELECT * FROM users";
        $stmt = $this->connect->query($result);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createQuery($username)
    {

        try {
            $query = "INSERT INTO users(fio) values (?)";
            $stmt = $this->connect->prepare($query);
            $stmt->execute(array($username));
            return "Completed";
        } catch (PDOException $e) {
            return $e->getMessage();
        }


    }

    public function editQuery($id, $username)
    {
        try {
            $query = "UPDATE users SET fio=? WHERE id=?";
            $stmt = $this->connect->prepare($query);
            $stmt->execute(array($username, $id));
            return "Completed";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    public function deleteQuery($delete)
    {
        try {
            $this->connect->beginTransaction();

            $query = "DELETE FROM users_tasks WHERE users_id = ?";
            $stmt = $this->connect->prepare($query);
            $stmt->execute(array($delete));


            $query2 = "DELETE FROM users WHERE id = ?";
            $stmt2 = $this->connect->prepare($query2);
            $stmt2->execute(array($delete));

            $this->connect->commit();
            return "Completed";
        } catch (PDOException $e) {
            $this->connect->rollBack();
            return $e->getMessage();

        }
    }
}