<?php

namespace app\controllers;

use app\dto\UserDto;
use app\service\UserService;
use Doctrine\ORM\EntityManager;


class UserController
{
    public UserService $userService;


    public function __construct(EntityManager $entityManager, public UserDto $userDto = new UserDto())
    {
        $this->userService = new UserService($entityManager);

    }

    public function printUsers(array $request): string
    {
        return($this->userService->printUsers());
    }

    public function createUser(array $request): void
    {
        $this->userDto->username = $request['username'];
        $this->userService->createUser($this->userDto);
    }

    public function editUser(array $request): void
    {
        $this->userDto->id = $request['id'];
        $this->userDto->username = $request['username'];
        $this->userService->createUser($this->userDto);
    }

    public function deleteUser(array $request): void
    {
        $this->userDto->id = $request['delete'];
        $this->userService->deleteUser($this->userDto);
    }
}