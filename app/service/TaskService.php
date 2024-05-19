<?php

namespace app\service;

use app\dto\IdName;
use app\dto\TaskDto;
use app\dto\TaskPdfDto;
use app\Entities\PrioritetEntity;
use app\Entities\TaskEntity;
use app\Entities\UserEntity;
use Doctrine\ORM\EntityManager;
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
            $taskDto->deadline = $task->getDedline();
            $taskDto->prioritetId = $task->getPrioritets()->getId();
            $taskDto->prioritetName = $task->getPrioritets()->getNamePrioritet();
            $taskDto->users = $task->getUsers()->map(function (UserEntity $userEntity):IdName {$userDto = new IdName(); $userDto->id = $userEntity->getId(); $userDto->name = $userEntity->getName(); return $userDto;})->toArray();
            $result[] = $taskDto;
        }
        return $result;
    }

    public function printTwo(): array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $result = $qb->select('t','p.namePrioritet', 'u.name')
            ->from(TaskEntity::class, 't')
            ->join('t.prioritets', 'p')
            ->leftJoin('t.users', 'u')
            ->where('u is not null');
        return $result->getQuery()->getArrayResult();

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
                $task->setDedline($taskDto->deadline);
                $task->setPrioritets($priority);
                $this->entityManager->persist($task);
                foreach ($taskDto->users as $value) {
                    $user = $this->entityManager->find(UserEntity::class,$value);
                    $user->setTask($task);
                    $this->entityManager->persist($user);
                }
                $this->entityManager->flush();
        } catch (Throwable $e) {
            sendFailure($e->getMessage());
        }


    }

    public function delete(int $id): void
    {
        try {
            $task = $this->entityManager->find(TaskEntity::class,$id);
            $this->entityManager->remove($task);
            $this->entityManager->flush();
        } catch (Throwable $e) {
            sendFailure($e->getMessage());
        }


    }

    public function getPdf(): void
    {
        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader);
        $result = $this->print();
        $i = 1;
        $res = [];
        foreach ($result as $task) {
            $taskPdf = new TaskPdfDto();
            if (count($task->users) > 0) {
                $taskPdf->count = count($task->users);
                $taskPdf->id = $i;
                $taskPdf->describe = $task->describe;
                $taskPdf->deadline = $task->deadline;
                $taskPdf->prioritetName = $task->prioritetName;
                $taskPdf->users = $task->users;
                $i++;
                $res[] = $taskPdf;
            }

        }

        $template = $twig->render('taskTable.html', ['tasks' => $res]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($template);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream();
    }

    public function getPriority(): array
    {
        $entityManager = getEntityManager();
        $priorities = $entityManager->getRepository(PrioritetEntity::class)->findAll();
        $result = [];
        foreach ($priorities as $user) {
            $prioritiesDto = new IdName();
            $prioritiesDto->id = $user->getId();
            $prioritiesDto->name = $user->getNamePrioritet();
            $result[] = $prioritiesDto;
        }
        return $result;
    }
}