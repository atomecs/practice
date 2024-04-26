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

    public function createUser(array $request): void
    {
        $userDto = new UserDto;
        $userDto->username = $request['username'];
        $this->userService->createUser($userDto);
    }

    public function editUser(array $request): void
    {
        $userDto = new UserDto;
        $userDto->id = $request['id'];
        $userDto->username = $request['username'];
        $this->userService->createUser($userDto);
    }

    public function deleteUser(array $request): void
    {
        $id = $request['delete'];
        $this->userService->deleteUser($id);
    }
}