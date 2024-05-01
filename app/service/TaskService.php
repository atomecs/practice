<?php

namespace app\service;

use app\dto\TaskDto;
use app\dto\UserDto;
use app\Entities\PrioritetEntity;
use app\Entities\TaskEntity;
use app\Entities\UserEntity;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Dompdf\Dompdf;
use Error;
use Exception;
use Throwable;

class TaskService
{

    public EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function printTasksTwo(): array
    {
        $allTasks = $this->entityManager->getRepository(TaskEntity::class)->findAll();
        $result = [];
        foreach ($allTasks as $task) {
            $taskDto = new TaskDto();
            $taskDto->id = $task->getId();
            $taskDto->describe = $task->getDescribe();
            $taskDto->deadline = $task->getDedline();
            $taskDto->prioritetId = $task->getPrioritets()->getId();
            $taskDto->prioritetName = $task->getPrioritets()->getPrioritet();
            $taskDto->users = $task->getUsers()->map(function (UserEntity $userEntity) {return [$userEntity->getId(), $userEntity->getName()];})->toArray();
            $result[] = $taskDto;
        }
        return $result;
    }

    public function printTasks(): array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $result = $qb->select('t.id', 't.describe', 't.dedline', 'p.prioritet', 'u.name')
            ->from(TaskEntity::class, 't')
            ->join('t.prioritets', 'p')
            ->leftJoin('t.users', 'u')
            ->where('u is not null');
        return $result->getQuery()->getArrayResult();

    }
    public function createTask(TaskDto $taskDto): void
    {
        if ($taskDto->id) {
            $task = $this->entityManager->find(TaskEntity::class, $taskDto->id);
            $task->removeUser();
        } else {
            $task = new TaskEntity;
        }
        try {

            $priority = $this->entityManager->find(PrioritetEntity::class, $taskDto->prioritetId);
            $task->setDescribe($taskDto->describe);
            $task->setDedline($taskDto->deadline);
            $task->setPrioritets($priority);
            $this->entityManager->persist($task);
            $this->entityManager->flush();

            foreach ($taskDto->users as $value) {
                $user = $this->entityManager->find(UserEntity::class,$value);
                $user->setTask($task);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
            }
        } catch (Throwable $e) {
            throw new Exception('wrong');
        }


    }

    public function deleteTask(int $id): void
    {
        try {
            $task = $this->entityManager->find(TaskEntity::class,$id);
            $this->entityManager->remove($task);
            $this->entityManager->flush();
        } catch (Throwable $e) {
            throw new Exception('wrong');
        }


    }

    public function getPdf()
    {
        $html = '<font face="Dejavu serif">
    <table align="center" cellspacing="2" border="1" cellpadding="5" width="300">
          <tr>
            <th>id</th>
            <th>Describe</th>
            <th>Deadline</th>
            <th>PrioritetName</th>
            <th>User</th>
          </tr>';
        $qb = $this->entityManager->createQueryBuilder();
        $result = $qb->select('t.id', 't.describe', 't.dedline', 'p.prioritet', 'u.name')
            ->from(TaskEntity::class, 't')
            ->join('t.prioritets', 'p')
            ->leftJoin('t.users', 'u')
            ->where('u is not null');
        $allTasks = $result->getQuery()->getArrayResult();
        foreach ($allTasks as $task) {
            $html .= '<tr>';
            foreach ($task as $item){
                $html .= '<td>'.$item.'</td>';

            }
            $html .= '</tr>';
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream();
    }
}