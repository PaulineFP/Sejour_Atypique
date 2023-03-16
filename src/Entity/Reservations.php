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
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\ManyToOne(targetEntity=Hebergement::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hebergement;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $person_nb;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $child_nb;

    /**
     * @ORM\Column(type="integer")
     */
    private $night_nb;

    /**
     * @ORM\Column(type="datetime")
     */
    private $arrived;

    /**
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getHebergement(): ?Hebergement
    {
        return $this->hebergement;
    }

    public function setHebergement(?Hebergement $hebergement): self
    {
        $this->hebergement = $hebergement;

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

    public function getPersonNb(): ?int
    {
        return $this->person_nb;
    }

    public function setPersonNb(int $person_nb): self
    {
        $this->person_nb = $person_nb;

        return $this;
    }

    public function getChildNb(): ?int
    {
        return $this->child_nb;
    }

    public function setChildNb(?int $child_nb): self
    {
        $this->child_nb = $child_nb;

        return $this;
    }

    public function getNightNb(): ?int
    {
        return $this->night_nb;
    }

    public function setNightNb(int $night_nb): self
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

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }
}
