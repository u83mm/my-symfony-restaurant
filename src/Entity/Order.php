<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $tableNumber = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $peopleQty = null;

    #[ORM\Column(nullable: true)]
    private ?array $aperitifs = null;

    #[ORM\Column(nullable: true)]
    private ?array $firsts = null;

    #[ORM\Column(nullable: true)]
    private ?array $seconds = null;

    #[ORM\Column(nullable: true)]
    private ?array $drinks = null;

    #[ORM\Column(nullable: true)]
    private ?array $desserts = null;

    #[ORM\Column(nullable: true)]
    private ?array $coffees = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTableNumber(): ?int
    {
        return $this->tableNumber;
    }

    public function setTableNumber(int $tableNumber): static
    {
        $this->tableNumber = $tableNumber;

        return $this;
    }

    public function getPeopleQty(): ?int
    {
        return $this->peopleQty;
    }

    public function setPeopleQty(int $peopleQty): static
    {
        $this->peopleQty = $peopleQty;

        return $this;
    }

    public function getAperitifs(): ?array
    {
        return $this->aperitifs;
    }

    public function setAperitifs(?array $aperitifs): static
    {
        $this->aperitifs = $aperitifs;

        return $this;
    }

    public function getFirsts(): ?array
    {
        return $this->firsts;
    }

    public function setFirsts(?array $firsts): static
    {
        $this->firsts = $firsts;

        return $this;
    }

    public function getSeconds(): ?array
    {
        return $this->seconds;
    }

    public function setSeconds(?array $seconds): static
    {
        $this->seconds = $seconds;

        return $this;
    }

    public function getDrinks(): ?array
    {
        return $this->drinks;
    }

    public function setDrinks(?array $drinks): static
    {
        $this->drinks = $drinks;

        return $this;
    }

    public function getDesserts(): ?array
    {
        return $this->desserts;
    }

    public function setDesserts(?array $desserts): static
    {
        $this->desserts = $desserts;

        return $this;
    }

    public function getCoffees(): ?array
    {
        return $this->coffees;
    }

    public function setCoffees(?array $coffees): static
    {
        $this->coffees = $coffees;

        return $this;
    }
}
