<?php

namespace app\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'prioritets')]
class PrioritetEntity
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;
    #[ORM\Column(name: 'prioritet', type: 'string')]
    private string $prioritet;

    public function getId(): int|null
    {
        return $this->id;
    }


    public function getPrioritet(): string|null
    {
        return $this->prioritet;
    }

    // .. (other code)
}