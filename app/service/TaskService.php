<?php

namespace app\service;

use app\dto\TaskDto;
use app\dto\UserDto;
use app\Entities\PrioritetEntity;
use app\Entities\TaskEntity;
use app\Entities\UserEntity;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Error;
use Exception;
use PDO;
use PDOException;
use Throwable;

class TaskService
{

    public EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function printTasks(): string
    {
        $allTasks = $this->entityManager->getRepository(TaskEntity::class)->findAll();
        $result = [];
        foreach ($allTasks as $task) {
            $taskDto = new TaskDto();
            $taskDto->id = $task->getId();
            $taskDto->describe = $task->getDescribe();
            $taskDto->deadline = $task->getDedline();
            $taskDto->prioritetId = $task->getPrioritets() ? $task->getPrioritets()->getPrioritet() : null;
            $taskDto->users = $task->getUsers();
            $result[] = $taskDto;
        }
        return json_encode($result);
    }

    public function createTask(TaskDto $taskDto, UserDto $userDto): void
    {
        if ($taskDto->id){
            $task = $this->entityManager->getRepository(TaskEntity::class)->find($taskDto->id);
            $task->removeUser();
        } else {
            $task = new TaskEntity;
        }
        try {
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
            } catch (Throwable $e) {
                throw new Exception('wrong');
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }



    }

    public function deleteTask(TaskDto $taskDto): void
    {
        try {
            try {
                $task = $this->entityManager->getRepository(TaskEntity::class)->find($taskDto->id);
                $this->entityManager->remove($task);
                $this->entityManager->flush();
            } catch (Throwable $e) {
                throw new Exception('wrong');
            }
        } catch (Exception $e){
            echo $e->getMessage();
        }

    }
}