<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use App\Service\UploaderHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipmentRepository::class)
 */
class Equipment
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
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity=Hebergement::class, inversedBy="hebergement_equipment")
     */
    private $hebergement_equipment;

    public function __construct()
    {
        $this->hebergement_equipment = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImagePath()
    {
        return UploaderHelper::EQUIPEMENT_IMAGE.'/'.$this->getImage();
    }

    /**
     * @return Collection<int, Hebergement>
     */
    public function getHebergementEquipment(): Collection
    {
        return $this->hebergement_equipment;
    }

    public function addHebergementEquipment(Hebergement $hebergementEquipment): self
    {
        if (!$this->hebergement_equipment->contains($hebergementEquipment)) {
            $this->hebergement_equipment[] = $hebergementEquipment;
        }

        return $this;
    }

    public function removeHebergementEquipment(Hebergement $hebergementEquipment): self
    {
        $this->hebergement_equipment->removeElement($hebergementEquipment);

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
