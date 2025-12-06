<?php

namespace App\Entity;

use App\Repository\DishDescriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DishDescriptionRepository::class)]
class DishDescription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;    

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $esDescription = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $enDescription = null;

    /**
     * @var Collection<int, Dish>
     */
    #[ORM\OneToMany(mappedBy: 'dishDescription', targetEntity: Dish::class, orphanRemoval: true)]
    private Collection $dishes;

    public function __construct()
    {
        $this->dishes = new ArrayCollection();
    }      

    public function __toString()
    {
        return ucfirst($this->getEnDescription());
    }  
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEsDescription(): ?string
    {
        return $this->esDescription;
    }

    public function setEsDescription(string $esDescription): static
    {
        $this->esDescription = $esDescription;

        return $this;
    }

    public function getEnDescription(): ?string
    {
        return $this->enDescription;
    }

    public function setEnDescription(string $enDescription): static
    {
        $this->enDescription = $enDescription;

        return $this;
    }

    /**
     * @return Collection<int, Dish>
     */
    public function getDishes(): Collection
    {
        return $this->dishes;
    }

    public function addDish(Dish $dish): static
    {
        if (!$this->dishes->contains($dish)) {
            $this->dishes->add($dish);
            $dish->setDishDescription($this);
        }

        return $this;
    }

    public function removeDish(Dish $dish): static
    {
        if ($this->dishes->removeElement($dish)) {
            // set the owning side to null (unless already changed)
            if ($dish->getDishDescription() === $this) {
                $dish->setDishDescription(null);
            }
        }

        return $this;
    }     
}
