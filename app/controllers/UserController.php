<?php

namespace app\controllers;

use app\dto\IdNameDto;
use app\service\UserService;
use Doctrine\ORM\EntityManager;


class UserController
{
    public UserService $userService;


    public function __construct(EntityManager $entityManager)
    {
        $this->userService = new UserService($entityManager);

    }

    public function print(): array
    {
        return $this->userService->print();
    }

    public function getPdf():void
    {
        $this->userService->getPdf();
    }

    public function save(array $request): void
    {
        $userDto = new IdNameDto;
        $userDto->name = $request['username'];
        if(isset($request['id'])){
            $userDto->id = $request['id'];
        }
        $this->userService->save($userDto);
    }


    public function delete(array $request): void
    {
        if (isset($request['id'])) {
            $id = $request['id'];
            $this->userService->delete($id);
        }

    }
}