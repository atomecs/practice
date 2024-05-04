<?php

namespace app\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'prioritets')]
class PrioritetEntity
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(name: 'prioritet', type: Types::STRING)]
    private string $namePrioritet;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNamePrioritet(): ?string
    {
        return $this->namePrioritet;
    }


}