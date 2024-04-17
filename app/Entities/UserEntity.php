<?php

namespace app\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class UserEntity
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private int|null $id = null;
    #[ORM\Column(name: 'fio', type: 'string')]
    private string $name;

    #[ORM\JoinTable(name: 'users_tasks')]
    #[ORM\JoinColumn(name: 'users_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'tasks_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: TaskEntity::class)]
    private Collection $task;

    public function __construct()
    {
        $this->task = new ArrayCollection();
    }
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

    public function setTask(TaskEntity $task): UserEntity
    {
        $this->task[] = $task;
        return $this;
    }

    public function removeTask(TaskEntity $task): UserEntity
    {
        if ($this->task->contains($task)) {
            $this->task->removeElement($task);
            if ($this->getTask() === $this){
                $this->setTask(null);
            }
        }
        return $this;
    }
    // .. (other code)
}