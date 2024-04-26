<?php

namespace app\service;

use app\dto\UserDto;
use Doctrine\ORM\EntityManager;
use Exception;
use app\Entities\UserEntity;
use Throwable;

class UserService
{

    public EntityManager $entityManager;


    public function __construct(EntityManager $entityManager)
    {
          $this->entityManager = $entityManager;
    }


    public function printUsers(): array
    {
        $userDto = new UserDto();
        $entityManager= getEntityManager();
        $users = $entityManager->getRepository(UserEntity::class)->findAll();
        $result = [];
        foreach ($users as $user) {
            $userDto->id = $user->getId();
            $userDto->username = $user->getName();
            $result[] = $userDto;
        }
        return $result;
    }

    public function createUser(UserDto $userDto): void
    {
        if ($userDto->id){
            $users = $this->entityManager->find(UserEntity::class, $userDto->id);
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


    public function deleteUser(int $id): void
    {
        try {
            try {
                $users = $this->entityManager->find(UserEntity::class, $id);
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