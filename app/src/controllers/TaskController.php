<?php

namespace src\controllers;

use src\dto\TaskDto;
use src\dto\UserDto;
use src\service\TaskService;

class TaskController
{
    public $taskService;
    public $taskDto;
    public $userDto;

    public function __construct()
    {

        $this->taskService = new TaskService();
        $this->taskDto = new TaskDto();
        $this->userDto = new UserDto();
    }

    public function getPage($request)
    {
        $page = $request['page'];
        $route = './lib/' . $page . '.php';
        return $this->taskService->getPage($route);
    }

    public function printTasks()
    {
        return($this->taskService->printTasks());
    }

    public function createTask($request)
    {
        $this->taskDto->describe = $request['describe'];
        $this->taskDto->deadline = $request['deadline'];
        $this->taskDto->prioritetId = $request['prioritet'];
        $this->userDto->id = explode(',', $request['user1']);
        return $this->taskService->createTask($this->taskDto, $this->userDto);
    }

    public function editTask($request)
    {
        $this->taskDto->id = $request['id'];
        $this->taskDto->describe = $request['describe'];
        $this->taskDto->deadline = $request['deadline'];
        $this->taskDto->prioritetId = $request['prioritet'];
        $this->userDto->id = explode(',', $request['user1']);;
        return $this->taskService->editTask($this->taskDto, $this->userDto);
    }

    public function deleteTask($request)
    {
        $this->taskDto->id = $request['delete'];
        return $this->taskService->deleteTask($this->taskDto);
    }
}