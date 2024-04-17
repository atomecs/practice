<?php

namespace app\service;

use app\dto\UserDto;
use PDO;
use PDOException;
use app\Entities\UserEntity;

class UserService
{

    public $entityManager;


    public function __construct($entityManager)
    {
          $this->entityManager = $entityManager;
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
        $users = $entityManager->getRepository('UserEntity')->findAll();
        return json_encode($users);
    }

    public function createUser(UserDto $userDto)
    {
        $users = new UserEntity();
        try {
            $users->setName($userDto->username);
            $this->entityManager->persist($users);
            $this->entityManager->flush();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function editUser(UserDto $userDto)
    {
        try {
            $users = $this->entityManager->getRepository(UserEntity::class)->find($userDto->id);
            $users->setName($userDto->username);
            $this->entityManager->flush();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function deleteUser(UserDto $userDto)
    {
        try {
            $users = $this->entityManager->getRepository(UserEntity::class)->find($userDto->id);
            $this->entityManager->remove($users);
            $this->entityManager->flush();
        } catch (PDOException $e) {
            return $e->getMessage();

        }
    }
}