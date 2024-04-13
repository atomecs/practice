<?php


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'tasks')]
class TaskEntity
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(name: 'describe', type: 'string')]
    private string $describe;

    #[ORM\Column(name: 'dedline', type: 'string')]
    private string $dedline;


    #[ORM\OneToOne(targetEntity: PrioritetEntity::class)]
    #[ORM\JoinColumn(name: 'fk_prioritet', referencedColumnName: 'id')]
    private int $prioritets;

    #[ManyToMany(targetEntity: UserEntity::class, mappedBy: 'tasks_id')]
    private Collection $users;


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

    public function getDedline(): ?string
    {
        return $this->dedline;
    }

    public function setDedline(?string $dedline): void
    {
        $this->dedline = $dedline;
    }

    public function getPrioritets(): int
    {
        return $this->prioritets;
    }

    public function setPrioritets(int $prioritets): void
    {
        $this->prioritets = $prioritets;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function setUsers(Collection $users): void
    {
        $this->users = $users;
    }
    // .. (other code)
}