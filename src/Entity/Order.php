<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
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
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $order_info;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $id_panier;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $treated;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $id_payment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getname(): ?string
    {
        return $this->name;
    }

    public function setname(string $name): self
    {
        $this->name = $name;

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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getOrderInfo(): ?string
    {
        return $this->order_info;
    }

    public function setOrderInfo(?string $order_info): self
    {
        $this->order_info = $order_info;

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

    public function getIdPanier(): ?string
    {
        return $this->id_panier;
    }

    public function setIdPanier(string $id_panier): self
    {
        $this->id_panier = $id_panier;

        return $this;
    }

    public function getTreated(): ?bool
    {
        return $this->treated;
    }

    public function setTreated(?bool $treated): self
    {
        $this->treated = $treated;

        return $this;
    }

    public function getIdPayment(): ?string
    {
        return $this->id_payment;
    }

    public function setIdPayment(string $id_payment): self
    {
        $this->id_payment = $id_payment;

        return $this;
    }
}
