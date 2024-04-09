<?php

namespace controllers;

use service\UserService;
use dto\UserDto;

class UserController
{
    public $userService;
    public $userDto;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->userDto = new UserDto();
    }

    public function getPage($request)
    {
        var_dump($request);
        $page = $request['page'];
        $route = './lib/' . $page . '.php';
        return $this->userService->getPage($route);
    }

    public function printUsers($request)
    {
        return($this->userService->printUsers());
    }

    public function createUser($request)
    {
        $this->userDto->username = $request['username'];
        return $this->userService->createUser($this->userDto);
    }

    public function editUser($request)
    {
        $this->userDto->id = $request['id'];
        $this->userDto->username = $request['username'];
        return $this->userService->editUser($this->userDto);
    }

    public function deleteUser($request)
    {
        $this->userDto->id = $request['delete'];
        return $this->userService->deleteUser($this->userDto);
    }
}