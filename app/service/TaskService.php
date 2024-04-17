<?php

namespace app\service;

use app\dto\TaskDto;
use app\dto\UserDto;
use app\Entities\PrioritetEntity;
use app\Entities\TaskEntity;
use app\Entities\UserEntity;
use PDO;
use PDOException;

class TaskService
{

    public $connect;
    public $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getPage($route)
    {
        if (file_exists($route)) {
            return require_once $route;
        } else {
            return "not found";
        }
    }

    public function printTasks()
    {
        return json_encode($this->entityManager->getRepository(TaskEntity::class)->findAll());
    }

    public function createTask(TaskDto $taskDto, UserDto $userDto)
    {
        $task = new TaskEntity;
        try {
            $priority = $this->entityManager->getRepository(PrioritetEntity::class)->find($taskDto->prioritetId);
            $task->setDescribe($taskDto->describe);
            $task->setDedline($taskDto->deadline);
            $task->setPrioritets($priority);
            $this->entityManager->persist($task);
            $this->entityManager->flush();
            foreach($userDto->id as $value){
                $user = $this->entityManager->getRepository(UserEntity::class)->find($value);
                $user->setTask($task);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

            }
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }


    }

    public function editTask(TaskDto $taskDto, UserDto $userDto)
    {
        try {
            $task = $this->entityManager->getRepository(TaskEntity::class)->find($taskDto->id);
            $priority = $this->entityManager->getRepository(PrioritetEntity::class)->find($taskDto->prioritetId);
            $task->removeUser();
            $task->setDescribe($taskDto->describe);
            $task->setDedline($taskDto->deadline);
            $task->setPrioritets($priority);
            $this->entityManager->persist($task);
            $this->entityManager->flush();
            foreach($userDto->id as $value){
                $user = $this->entityManager->getRepository(UserEntity::class)->find($value);
                $user->setTask($task);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

            }
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            $this->connect->rollBack();
        }
    }

    public function deleteTask(TaskDto $taskDto)
    {
        try {
            $task = $this->entityManager->getRepository(TaskEntity::class)->find($taskDto->id);
            $this->entityManager->remove($task);
            $this->entityManager->flush();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            $this->connect->rollBack();
        }
    }
}