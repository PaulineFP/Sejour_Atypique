<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users
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
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity=Reservations::class, mappedBy="reference", orphanRemoval=true)
     */
    private $reservation_reference;

    public function __construct()
    {
        $this->reservation_reference = new ArrayCollection();
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Reservations>
     */
    public function getReservationReference(): Collection
    {
        return $this->reservation_reference;
    }

    public function addReservationReference(Reservations $reservationReference): self
    {
        if (!$this->reservation_reference->contains($reservationReference)) {
            $this->reservation_reference[] = $reservationReference;
            $reservationReference->setReference($this);
        }

        return $this;
    }

    public function removeReservationReference(Reservations $reservationReference): self
    {
        if ($this->reservation_reference->removeElement($reservationReference)) {
            // set the owning side to null (unless already changed)
            if ($reservationReference->getReference() === $this) {
                $reservationReference->setReference(null);
            }
        }

        return $this;
    }
}
