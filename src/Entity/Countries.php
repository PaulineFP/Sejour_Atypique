<?php

namespace App\Entity;

use App\Repository\CountriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountriesRepository::class)
 */
class Countries
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
     * @ORM\OneToMany(targetEntity=Hebergement::class, mappedBy="hebergementCountry", orphanRemoval=true)
     */
    private $country_accommodations;

    public function __construct()
    {
        $this->country_accommodations = new ArrayCollection();
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
     * @return Collection<int, Hebergement>
     */
    public function getCountryAccommodations(): Collection
    {
        return $this->country_accommodations;
    }

    public function addCountryAccommodation(Hebergement $countryAccommodation): self
    {
        if (!$this->country_accommodations->contains($countryAccommodation)) {
            $this->country_accommodations[] = $countryAccommodation;
            $countryAccommodation->setHebergementCountry($this);
        }

        return $this;
    }

    public function removeCountryAccommodation(Hebergement $countryAccommodation): self
    {
        if ($this->country_accommodations->removeElement($countryAccommodation)) {
            // set the owning side to null (unless already changed)
            if ($countryAccommodation->getHebergementCountry() === $this) {
                $countryAccommodation->setHebergementcountry(null);
            }
        }

        return $this;
    }
}
