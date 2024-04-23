<?php

namespace app\controllers;

use app\dto\TaskDto;
use app\dto\UserDto;
use app\service\TaskService;
use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManager;

class TaskController
{
    public $taskService;



    public function __construct( EntityManager $entityManager, public TaskDto $taskDto = new TaskDto(), public UserDto $userDto = new UserDto())
    {

        $this->taskService = new TaskService($entityManager);
    }

    public function getPage(array $request): string
    {
        $page = $request['page'];
        $route = './lib/' . $page . '.php';
        return $this->taskService->getPage($route);
    }



    public function createTask(array $request): void
    {
        $this->taskDto->describe = $request['describe'];
        $this->taskDto->deadline = $request['deadline'];
        $this->taskDto->prioritetId = $request['prioritet'];
        $this->userDto->id = explode(',', $request['user1']);
        $this->taskService->createTask($this->taskDto, $this->userDto);
    }

    public function editTask(array $request): void
    {
        $this->taskDto->id = $request['id'];
        $this->taskDto->describe = $request['describe'];
        $this->taskDto->deadline = $request['deadline'];
        $this->taskDto->prioritetId = $request['prioritet'];
        $this->userDto->id = explode(',', $request['user1']);;
        $this->taskService->createTask($this->taskDto, $this->userDto);
    }

    public function deleteTask(array $request): void
    {
        $this->taskDto->id = $request['delete'];
        $this->taskService->deleteTask($this->taskDto);
    }
}