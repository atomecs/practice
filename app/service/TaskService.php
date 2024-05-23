<?php

namespace app\service;

use app\dto\IdNameDto;
use app\dto\TaskDto;
use app\dto\TaskPdfDto;
use app\Entities\PrioritetEntity;
use app\Entities\TaskEntity;
use app\Entities\UserEntity;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;
use Dompdf\Dompdf;
use Throwable;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TaskService
{

    public EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function print(): array
    {
        $allTasks = $this->entityManager->getRepository(TaskEntity::class)->findAll();
        $result = [];
        foreach ($allTasks as $task) {
            $taskDto = new TaskDto();
            $taskDto->id = $task->getId();
            $taskDto->describe = $task->getDescribe();
            $taskDto->deadline = $task->getDeadline();
            $taskDto->prioritetId = $task->getPrioritets()->getId();
            $taskDto->prioritetName = $task->getPrioritets()->getNamePrioritet();
            $taskDto->users = $task->getUsers()->map(function (UserEntity $userEntity):IdNameDto {
                $userDto = new IdNameDto();
                $userDto->id = $userEntity->getId();
                $userDto->name = $userEntity->getName();
                return $userDto;
            })->toArray();
            $result[] = $taskDto;
        }
        return $result;
    }


    public function save(TaskDto $taskDto): void
    {
        try {
            if (isset($taskDto->id)) {
                $task = $this->entityManager->find(TaskEntity::class, $taskDto->id);
                $task->removeUser();
            } else {
                $task = new TaskEntity;
            }
                $priority = $this->entityManager->find(PrioritetEntity::class, $taskDto->prioritetId);
                $task->setDescribe($taskDto->describe);
                $task->setDeadline($taskDto->deadline);
                $task->setPrioritets($priority);
                $this->entityManager->persist($task);
                $users = array_map(function ($value): UserEntity {
                    return $this->entityManager->find(UserEntity::class, $value);
                }, $taskDto->users);

                foreach ($users as $user){
                    $user->setTask($task);
                    $this->entityManager->persist($user);
                    $this->entityManager->flush();
                }
        } catch (Exception $e) {
            sendFailure($e->getMessage());
        }


    }

    public function delete(int $id): void
    {
        try {
            $task = $this->entityManager->find(TaskEntity::class,$id);
            $this->entityManager->remove($task);
            $this->entityManager->flush();
        } catch (Exception $e) {
            sendFailure($e->getMessage());
        }
    }

    public function getPdf(): void
    {
        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader);
        $result = $this->print();
        $template = $twig->render('taskTable.html', ['tasks' => $result]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($template);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream();
    }

    public function getPriority(): array
    {
        $priorities = $this->entityManager->getRepository(PrioritetEntity::class)->findAll();
        $result = [];
        foreach ($priorities as $user) {
            $prioritiesDto = new IdNameDto();
            $prioritiesDto->id = $user->getId();
            $prioritiesDto->name = $user->getNamePrioritet();
            $result[] = $prioritiesDto;
        }
        return $result;
    }
}