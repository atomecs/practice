<?php

class UserController
{
    public $userService;

    public function __construct(){
        require_once "./service/UserService.php";
        $this->userService = new UserService();
    }
    public function getPage(){
        $page = $_GET['page'];
        $route = './lib/'.$page.'.php';
        return $this->userService->givePage($route);
    }

    public function printUsers()
    {
        var_dump($this->userService->printAll());
    }
    public function createUser()
    {
        $username = $_POST['username'];
        return $this->userService->createQuery($username);
    }

    public function editUser()
    {
        $id = $_POST['id'];
        $username = $_POST['username'];
        return $this->userService->editQuery($id,$username);
    }

    public function deleteUser()
    {
        $delete = $_POST['delete'];
        return $this->userService->deleteQuery($delete);
    }
}