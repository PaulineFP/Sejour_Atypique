<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationsRepository::class)
 */
class Reservations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="reservation_reference")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reference;

    /**
     * @ORM\ManyToOne(targetEntity=Hebergement::class, inversedBy="reservation_reference")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hebergement_id;

    /**
     * @ORM\Column(type="date")
     */
    private $created_at;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=0)
     */
    private $person_nb;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=0, nullable=true)
     */
    private $child_nb;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=0)
     */
    private $night_nb;

    /**
     * @ORM\Column(type="date")
     */
    private $arrived;

    /**
     * @ORM\Column(type="decimal", precision=11, scale=2)
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?Users
    {
        return $this->reference;
    }

    public function setReference(?Users $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getHebergementId(): ?Hebergement
    {
        return $this->hebergement_id;
    }

    public function setHebergementId(?Hebergement $hebergement_id): self
    {
        $this->hebergement_id = $hebergement_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPersonNb(): ?string
    {
        return $this->person_nb;
    }

    public function setPersonNb(string $person_nb): self
    {
        $this->person_nb = $person_nb;

        return $this;
    }

    public function getChildNb(): ?string
    {
        return $this->child_nb;
    }

    public function setChildNb(?string $child_nb): self
    {
        $this->child_nb = $child_nb;

        return $this;
    }

    public function getNightNb(): ?string
    {
        return $this->night_nb;
    }

    public function setNightNb(string $night_nb): self
    {
        $this->night_nb = $night_nb;

        return $this;
    }

    public function getArrived(): ?\DateTimeInterface
    {
        return $this->arrived;
    }

    public function setArrived(\DateTimeInterface $arrived): self
    {
        $this->arrived = $arrived;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
