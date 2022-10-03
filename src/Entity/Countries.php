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
    private $Country;

    /**
     * @ORM\OneToMany(targetEntity=Hebergement::class, mappedBy="hebergement_region", orphanRemoval=true)
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

    public function getCountry(): ?string
    {
        return $this->Country;
    }

    public function setCountry(string $Country): self
    {
        $this->Country = $Country;

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
            $countryAccommodation->setHebergementRegion($this);
        }

        return $this;
    }

    public function removeCountryAccommodation(Hebergement $countryAccommodation): self
    {
        if ($this->country_accommodations->removeElement($countryAccommodation)) {
            // set the owning side to null (unless already changed)
            if ($countryAccommodation->getHebergementRegion() === $this) {
                $countryAccommodation->setHebergementRegion(null);
            }
        }

        return $this;
    }
}
