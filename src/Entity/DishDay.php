<?php

namespace App\Entity;

use App\Repository\DishDayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DishDayRepository::class)]
class DishDay
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $categoryName = null;

    #[ORM\OneToMany(mappedBy: 'dishDay', targetEntity: Dish::class)]
    private Collection $dishes;

    public function __construct()
    {
        $this->dishes = new ArrayCollection();
    }
    
    public function __toString()
    {
        return ucfirst($this->getCategoryName());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): self
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    /**
     * @return Collection<int, Dish>
     */
    public function getDishes(): Collection
    {
        return $this->dishes;
    }

    public function addDish(Dish $dish): self
    {
        if (!$this->dishes->contains($dish)) {
            $this->dishes->add($dish);
            $dish->setDishDay($this);
        }

        return $this;
    }

    public function removeDish(Dish $dish): self
    {
        if ($this->dishes->removeElement($dish)) {
            // set the owning side to null (unless already changed)
            if ($dish->getDishDay() === $this) {
                $dish->setDishDay(null);
            }
        }

        return $this;
    }
}
