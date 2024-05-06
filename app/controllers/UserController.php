<?php

namespace app\controllers;

use app\dto\UserDto;
use app\service\UserService;
use Doctrine\ORM\EntityManager;


class UserController
{
    public UserService $userService;


    public function __construct(EntityManager $entityManager)
    {
        $this->userService = new UserService($entityManager);

    }

    public function printUsers(): array
    {
        return($this->userService->printUsers());
    }

    public function getPdf():void
    {
        $this->userService->getPdf();
    }

    public function createOrEditUser(array $request): void
    {
        $userDto = new UserDto;
        $userDto->username = $request['username'];
        if(isset($request['id'])){
            $userDto->id = $request['id'];
        }
        $this->userService->createOrEditUser($userDto);
    }


    public function deleteUser(array $request): void
    {
        $id = $request['id'];
        $this->userService->deleteUser($id);
    }
}