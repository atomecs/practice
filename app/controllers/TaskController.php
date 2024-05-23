<?php

namespace app\controllers;

use app\dto\TaskDto;
use app\service\TaskService;
use Doctrine\ORM\EntityManager;

class TaskController
{
    public $taskService;



    public function __construct(EntityManager $entityManager)
    {

        $this->taskService = new TaskService($entityManager);
    }

    public function print(): array
    {
        return $this->taskService->print();
    }

    public function getPdf(): void
    {
        $this->taskService->getPdf();
    }

    public function save(array $request): void
    {
        $taskDto = new TaskDto();
        $taskDto->describe = $request['describe'];
        $taskDto->deadline = $request['deadline'];
        $taskDto->prioritetId = $request['prioritet'];
        $taskDto->users = $request['user1'];
        if (isset($request['id'])) {
            $taskDto->id = $request['id'];
        }
        $this->taskService->save($taskDto);
    }


    public function delete(array $request): void
    {
        if (isset($request['id'])) {
            $id = $request['id'];
            $this->taskService->delete($id);
        }
    }

    public function getPriority(): array
    {
        return $this->taskService->getPriority();
    }
}