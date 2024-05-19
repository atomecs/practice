<?php

namespace app\service;

use app\dto\IdName;
use app\Entities\UserEntity;
use Doctrine\ORM\EntityManager;
use Dompdf\Dompdf;
use Throwable;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class UserService
{

    public EntityManager $entityManager;


    public function __construct(EntityManager $entityManager)
    {
          $this->entityManager = $entityManager;
    }


    public function print(): array
    {

        $entityManager= getEntityManager();
        $users = $entityManager->getRepository(UserEntity::class)->findAll();
        $result = [];
        foreach ($users as $user) {
            $userDto = new IdName();
            $userDto->id = $user->getId();
            $userDto->name = $user->getName();
            $result[] = $userDto;
        }
        return $result;
    }

    public function save(IdName $userDto): void
    {
        if (isset($userDto->id)){
            $users = $this->entityManager->find(UserEntity::class, $userDto->id);
        } else {
            $users = new UserEntity();
        }
        try {
                $users->setName($userDto->name);
                $this->entityManager->persist($users);
                $this->entityManager->flush();
        } catch (Throwable $e) {
            sendFailure($e->getMessage());
        }

    }


    public function delete(int $id): void
    {
        try {
                $users = $this->entityManager->find(UserEntity::class, $id);
                $this->entityManager->remove($users);
                $this->entityManager->flush();
        } catch (Throwable $e) {
            sendFailure($e->getMessage());
        }

    }

    public function getPdf(): void
    {
        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader);
        $users = $this->entityManager->getRepository(UserEntity::class)->findAll();
        $i = 1;
        $result = [];
        foreach ($users as $user) {
            $userDto = new IdName();
            $userDto->id = $i;
            $userDto->name = $user->getName();
            $result[] = $userDto;
            $i++;
        }
        $template = $twig->render('userTable.html', ['users' => $result]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($template);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream();
    }
}