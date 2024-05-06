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


    public function printTasks(): array
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
            $taskDto->users = $task->getUsers()->map(function (UserEntity $userEntity):UserDto {$userDto = new UserDto(); $userDto->id = $userEntity->getId(); $userDto->username = $userEntity->getName(); return $userDto;})->toArray();
            $result[] = $taskDto;
        }
        return $result;
    }

    public function printTasksTwo(): array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $result = $qb->select('t','p.namePrioritet', 'u.name')
            ->from(TaskEntity::class, 't')
            ->join('t.prioritets', 'p')
            ->leftJoin('t.users', 'u')
            ->where('u is not null');
        return $result->getQuery()->getArrayResult();

    }
    public function createOrEditTask(TaskDto $taskDto): void
    {
        if (isset($taskDto->id)) {
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
            foreach ($taskDto->users as $value) {
                $user = $this->entityManager->find(UserEntity::class,$value);
                $user->setTask($task);
                $this->entityManager->persist($user);
            }
            $this->entityManager->flush();
        } catch (Throwable $e) {
            throw new Exception('Something went wrong');
        }


    }

    public function deleteTask(int $id): void
    {
        try {
            $task = $this->entityManager->find(TaskEntity::class,$id);
            $this->entityManager->remove($task);
            $this->entityManager->flush();
        } catch (Throwable $e) {
            throw new Exception('Something went wrong');
        }


    }

    public function getPdf(): void
    {
        $html = '<font face="Dejavu serif">
    <table align="center" cellspacing="2" border="1" cellpadding="5" width="300">
          <tr>
            <th>№</th>
            <th>Describe</th>
            <th>Deadline</th>
            <th>PrioritetName</th>
            <th>User</th>
          </tr>';
        $result = $this->printTasks();
        $i = 1;
        foreach ($result as $task) {
            $count = count($task->users);
            if ($count > 0){
                $html .= '<tr>';
                $html .= "<td rowspan='$count'>".$i.'</td>';
                $html .= "<td rowspan='$count'>".$task->describe.'</td>';
                $html .= "<td rowspan='$count'>".$task->deadline.'</td>';
                $html .= "<td rowspan='$count'>".$task->prioritetName.'</td>';
                $html .= "<td>".$task->users[0]->username.'</td>';
                $html .= '</tr>';
                if ($count > 1){
                    $isFirst = true;
                    foreach ($task->users as $user){
                        if ($isFirst)
                        {
                            $isFirst = false;
                            continue;
                        }
                        $html .= '<tr>';
                        $html .= "<td>".$user->username.'</td>';
                        $html .= '</tr>';
                    }
                }
                $i++;
            }

        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream();
    }
}