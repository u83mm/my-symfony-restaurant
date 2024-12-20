<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true])]
    private ?int $tableNumber = null;

    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true])]
    private ?int $peopleQty = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => null])]
    private ?string $aperitifs = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => null])]
    private ?string $aperitifsQty = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => '0'])]
    private ?string $aperitifsFinished = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => null])]
    private ?string $firsts = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => null])]
    private ?string $firstsQty = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => '0'])]
    private ?string $firstsFinished = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => null])]
    private ?string $seconds = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => null])]
    private ?string $secondsQty = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => '0'])]
    private ?string $secondsFinished = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => null])]
    private ?string $desserts = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => null])]
    private ?string $dessertsQty = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => '0'])]
    private ?string $dessertsFinished = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => null])]
    private ?string $drinks = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => null])]
    private ?string $drinksQty = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => '0'])]
    private ?string $drinksFinished = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => null])]
    private ?string $coffees = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => null])]
    private ?string $coffeesQty = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['default' => '0'])]
    private ?string $coffeesFinished = null;

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

    public function getAperitifs(): ?string
    {
        return $this->aperitifs;
    }

    public function setAperitifs(?string $aperitifs): static
    {
        $this->aperitifs = $aperitifs;

        return $this;
    }

    public function getAperitifsQty(): ?string
    {
        return $this->aperitifsQty;
    }

    public function setAperitifsQty(?string $aperitifsQty): static
    {
        $this->aperitifsQty = $aperitifsQty;

        return $this;
    }

    public function getAperitifsFinished(): ?string
    {
        return $this->aperitifsFinished;
    }

    public function setAperitifsFinished(?string $aperitifsFinished): static
    {
        $this->aperitifsFinished = $aperitifsFinished;

        return $this;
    }

    public function getFirsts(): ?string
    {
        return $this->firsts;
    }

    public function setFirsts(?string $firsts): static
    {
        $this->firsts = $firsts;

        return $this;
    }

    public function getFirstsQty(): ?string
    {
        return $this->firstsQty;
    }

    public function setFirstsQty(?string $firstsQty): static
    {
        $this->firstsQty = $firstsQty;

        return $this;
    }

    public function getFirstsFinished(): ?string
    {
        return $this->firstsFinished;
    }

    public function setFirstsFinished(?string $firstsFinished): static
    {
        $this->firstsFinished = $firstsFinished;

        return $this;
    }

    public function getSeconds(): ?string
    {
        return $this->seconds;
    }

    public function setSeconds(?string $seconds): static
    {
        $this->seconds = $seconds;

        return $this;
    }

    public function getSecondsQty(): ?string
    {
        return $this->secondsQty;
    }

    public function setSecondsQty(?string $secondsQty): static
    {
        $this->secondsQty = $secondsQty;

        return $this;
    }

    public function getSecondsFinished(): ?string
    {
        return $this->secondsFinished;
    }

    public function setSecondsFinished(?string $secondsFinished): static
    {
        $this->secondsFinished = $secondsFinished;

        return $this;
    }

    public function getDesserts(): ?string
    {
        return $this->desserts;
    }

    public function setDesserts(?string $desserts): static
    {
        $this->desserts = $desserts;

        return $this;
    }

    public function getDessertsQty(): ?string
    {
        return $this->dessertsQty;
    }

    public function setDessertsQty(?string $dessertsQty): static
    {
        $this->dessertsQty = $dessertsQty;

        return $this;
    }

    public function getDessertsFinished(): ?string
    {
        return $this->dessertsFinished;
    }

    public function setDessertsFinished(?string $dessertsFinished): static
    {
        $this->dessertsFinished = $dessertsFinished;

        return $this;
    }

    public function getDrinks(): ?string
    {
        return $this->drinks;
    }

    public function setDrinks(?string $drinks): static
    {
        $this->drinks = $drinks;

        return $this;
    }

    public function getDrinksQty(): ?string
    {
        return $this->drinksQty;
    }

    public function setDrinksQty(?string $drinksQty): static
    {
        $this->drinksQty = $drinksQty;

        return $this;
    }

    public function getDrinksFinished(): ?string
    {
        return $this->drinksFinished;
    }

    public function setDrinksFinished(?string $drinksFinished): static
    {
        $this->drinksFinished = $drinksFinished;

        return $this;
    }

    public function getCoffees(): ?string
    {
        return $this->coffees;
    }

    public function setCoffees(?string $coffees): static
    {
        $this->coffees = $coffees;

        return $this;
    }

    public function getCoffeesQty(): ?string
    {
        return $this->coffeesQty;
    }

    public function setCoffeesQty(?string $coffeesQty): static
    {
        $this->coffeesQty = $coffeesQty;

        return $this;
    }

    public function getCoffeesFinished(): ?string
    {
        return $this->coffeesFinished;
    }

    public function setCoffeesFinished(?string $coffeesFinished): static
    {
        $this->coffeesFinished = $coffeesFinished;

        return $this;
    }
}
