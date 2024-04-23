<?php

namespace app\service;

use app\dto\UserDto;
use Doctrine\ORM\EntityManager;
use Exception;
use PDO;
use PDOException;
use app\Entities\UserEntity;
use Throwable;

class UserService
{

    public EntityManager $entityManager;


    public function __construct(EntityManager $entityManager)
    {
          $this->entityManager = $entityManager;
    }


    public function printUsers(): string
    {
        $entityManager= getEntityManager();
        $users = $entityManager->getRepository(UserEntity::class)->findAll();
        return json_encode($users);
    }

    public function createUser(UserDto $userDto): void
    {
        if ($userDto->id){
            $users = $this->entityManager->getRepository(UserEntity::class)->find($userDto->id);
        } else {
            $users = new UserEntity();
        }
        try {
            try {
                $users->setName($userDto->username);
                $this->entityManager->persist($users);
                $this->entityManager->flush();
            } catch (Throwable) {
                throw new Exception('wrong');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }


    public function deleteUser(UserDto $userDto): void
    {
        try {
            try {
                $users = $this->entityManager->getRepository(UserEntity::class)->find($userDto->id);
                $this->entityManager->remove($users);
                $this->entityManager->flush();
            } catch (Throwable) {
                throw new Exception('wrong');

            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
}