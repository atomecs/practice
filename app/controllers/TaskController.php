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



    public function __construct(EntityManager $entityManager)
    {

        $this->taskService = new TaskService($entityManager);
    }

    public function printTasks(): array
    {
        return($this->taskService->printTasks());
    }
    public function createTask(array $request): void
    {
        $taskDto = new TaskDto();
        $taskDto->describe = $request['describe'];
        $taskDto->deadline = $request['deadline'];
        $taskDto->prioritetId = $request['prioritet'];
        $taskDto->users = explode(',', $request['user1']);
        $this->taskService->createTask($taskDto);
    }

    public function editTask(array $request): void
    {
        $taskDto = new TaskDto();
        $taskDto->id = $request['id'];
        $taskDto->describe = $request['describe'];
        $taskDto->deadline = $request['deadline'];
        $taskDto->prioritetId = $request['prioritet'];
        $taskDto->users = explode(',', $request['user1']);
        $this->taskService->createTask($taskDto);
    }

    public function deleteTask(array $request): void
    {
        $id = $request['delete'];
        $this->taskService->deleteTask($id);
    }
}