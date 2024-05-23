<?php


namespace app\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ManyToMany;

#[ORM\Entity]
#[ORM\Table(name: 'tasks')]
class TaskEntity
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private int $id;

    #[ORM\Column(name: 'describe', type: Types::STRING)]
    private string $describe;

    #[ORM\Column(name: 'dedline', type: Types::STRING)]
    private string $deadline;


    #[ORM\OneToOne(targetEntity: PrioritetEntity::class)]
    #[ORM\JoinColumn(name: 'fk_prioritet', referencedColumnName: 'id')]
    private ?PrioritetEntity $prioritets;

    #[ORM\JoinTable(name: 'users_tasks')]
    #[ORM\JoinColumn(name: 'tasks_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'users_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: UserEntity::class)]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDescribe(): ?string
    {
        return $this->describe;
    }

    public function setDescribe(?string $describe): void
    {
        $this->describe = $describe;
    }

    public function getDeadline(): ?string
    {
        return $this->deadline;
    }

    public function setDeadline(?string $deadline): void
    {
        $this->deadline = $deadline;
    }

    public function getPrioritets(): ?PrioritetEntity
    {
        return $this->prioritets;
    }

    public function setPrioritets(?PrioritetEntity $prioritets): void
    {
        $this->prioritets = $prioritets;
    }
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function setUsers(UserEntity $users): void
    {
        $this->users->add($users);
    }

    public function removeUser(): TaskEntity
    {
        $this->users = new ArrayCollection();
        return $this;
    }

}