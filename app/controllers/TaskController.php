<?php

class TaskController
{
    public $taskService;

    public function __construct(){
        require_once "./service/TaskService.php";
        $this->taskService = new TaskService();
    }
    public function getPage(){
        $page = $_GET['page'];
        $route = './lib/'.$page.'.php';
        return $this->taskService->givePage($route);
    }

    public function printTasks()
    {
        var_dump($this->taskService->printAll());
    }
    public function createTask()
    {
        $describe = $_POST['describe'];
        $deadline = $_POST['deadline'];
        $prioritetId = $_POST['prioritet'];
        $userId1 = $_POST['user1'];
        $userId2 = $_POST['user2'];
        return $this->taskService->createQuery($describe, $deadline, $prioritetId, $userId1, $userId2);
    }

    public function editTask()
    {
        $id = $_POST['id'];
        $describe = $_POST['describe'];
        $deadline = $_POST['deadline'];
        $prioritetId = $_POST['prioritet'];
        $userId1 = $_POST['user1'];
        $userId2 = $_POST['user2'];
        return $this->taskService->editQuery($id,$describe, $deadline, $prioritetId, $userId1, $userId2);
    }

    public function deleteTask()
    {
        $delete = $_POST['delete'];
        return $this->taskService->deleteQuery($delete);
    }
}