<?php

namespace App\Entity;

use App\Repository\DishMenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DishMenuRepository::class)]
class DishMenu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $menuCategory = null;

    #[ORM\OneToMany(mappedBy: 'dishMenu', targetEntity: Dish::class)]
    private Collection $dishes;

    #[ORM\Column(length: 25)]
    private ?string $menuEmoji = null;

    public function __construct()
    {
        $this->dishes = new ArrayCollection();
    }

    public function __toString()
    {
        return ucfirst($this->getMenuCategory());
    }   


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMenuCategory(): ?string
    {
        return $this->menuCategory;
    }

    public function setMenuCategory(string $menuCategory): self
    {
        $this->menuCategory = $menuCategory;

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
            $dish->setDishMenu($this);
        }

        return $this;
    }

    public function removeDish(Dish $dish): self
    {
        if ($this->dishes->removeElement($dish)) {
            // set the owning side to null (unless already changed)
            if ($dish->getDishMenu() === $this) {
                $dish->setDishMenu(null);
            }
        }

        return $this;
    }

    public function getMenuEmoji(): ?string
    {
        return $this->menuEmoji;
    }

    public function setMenuEmoji(string $menuEmoji): static
    {
        $this->menuEmoji = $menuEmoji;

        return $this;
    }
}
