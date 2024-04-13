<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class UserEntity
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(name: 'fio', type: 'string')]
    private string $name;

    #[ORM\ManyToMany(targetEntity: TaskEntity::class, inversedBy: 'users_id')]
    #[ORM\JoinTable(name: 'users_tasks')]
    private Collection $task;

    public function getId(): int|null
    {
        return $this->id;
    }


    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getTask(): Collection
    {
        return $this->task;
    }

    public function setTask(Collection $task): void
    {
        $this->task = $task;
    }

    // .. (other code)
}