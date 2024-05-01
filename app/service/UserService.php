<?php

namespace app\service;

use app\dto\UserDto;
use Doctrine\ORM\EntityManager;
use Dompdf\Dompdf;
use Exception;
use app\Entities\UserEntity;
use Throwable;

class UserService
{

    public EntityManager $entityManager;


    public function __construct(EntityManager $entityManager)
    {
          $this->entityManager = $entityManager;
    }


    public function printUsers(): array
    {

        $entityManager= getEntityManager();
        $users = $entityManager->getRepository(UserEntity::class)->findAll();
        $result = [];
        foreach ($users as $user) {
            $userDto = new UserDto();
            $userDto->id = $user->getId();
            $userDto->username = $user->getName();
            $result[] = $userDto;
        }
        return $result;
    }

    public function createUser(UserDto $userDto): void
    {
        if ($userDto->id){
            $users = $this->entityManager->find(UserEntity::class, $userDto->id);
        } else {
            $users = new UserEntity();
        }
        try {
            try {
                $users->setName($userDto->username);
                $this->entityManager->persist($users);
                $this->entityManager->flush();
            } catch (Throwable) {
                throw new Exception('wrong');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }


    public function deleteUser(int $id): void
    {
        try {
            try {
                $users = $this->entityManager->find(UserEntity::class, $id);
                $this->entityManager->remove($users);
                $this->entityManager->flush();
            } catch (Throwable) {
                throw new Exception('wrong');

            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    public function getPdf(): void
    {
        $html = '<font face="Dejavu serif">
        <table align="center" cellspacing="2" border="1" cellpadding="5" width="300">
          <tr>
            <th>id</th>
            <th>Name</th>
          </tr>';
        $entityManager= getEntityManager();
        $users = $entityManager->getRepository(UserEntity::class)->findAll();
        foreach ($users as $user) {
            $html .= '<tr>';
            $html.= '<td>'. $user->getId().'</td>';
            $html.= '<td>'.$user->getName().'</td>';
            $html .= '</tr>';
        }
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream();
    }
}