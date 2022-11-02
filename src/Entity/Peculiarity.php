<?php

namespace App\Entity;

use App\Repository\PeculiarityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PeculiarityRepository::class)
 */
class Peculiarity
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon;

    /**
     * @ORM\ManyToMany(targetEntity=Hebergement::class, inversedBy="relation_particularite")
     */
    private $relation_hebergement;

    public function __construct()
    {
        $this->relation_hebergement = new ArrayCollection();
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return Collection<int, Hebergement>
     */
    public function getRelationHebergement(): Collection
    {
        return $this->relation_hebergement;
    }

    public function addRelationHebergement(Hebergement $relationHebergement): self
    {
        if (!$this->relation_hebergement->contains($relationHebergement)) {
            $this->relation_hebergement[] = $relationHebergement;
        }

        return $this;
    }

    public function removeRelationHebergement(Hebergement $relationHebergement): self
    {
        $this->relation_hebergement->removeElement($relationHebergement);

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

}
