<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriesRepository::class)
 */
class Categories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=hebergement::class, inversedBy="categories")
     */
    private $categoryRelations;

    public function __construct()
    {
        $this->categoryRelations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }    

    /**
     * @return Collection<int, hebergement>
     */
    public function getCategoryRelations(): Collection
    {
        return $this->categoryRelations;
    }

    public function addCategoryRelation(hebergement $categoryRelation): self
    {
        if (!$this->categoryRelations->contains($categoryRelation)) {
            $this->categoryRelations[] = $categoryRelation;
        }

        return $this;
    }

    public function removeCategoryRelation(hebergement $categoryRelation): self
    {
        $this->categoryRelations->removeElement($categoryRelation);

        return $this;
    }
}
