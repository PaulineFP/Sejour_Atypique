<?php

namespace App\Entity;

use App\Repository\HebergementRepository;
use App\Service\UploaderHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HebergementRepository::class)
 */
class Hebergement
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieux;

    /**
     * @ORM\Column(type="text")
     */
    private $description;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surface;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publicationDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastUpdateDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $promotion;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPromotional;

    /**
     * @ORM\ManyToMany(targetEntity=Categories::class, mappedBy="hebergements")
     */
    private $categories;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $tarif;

    /**
     * @ORM\ManyToOne(targetEntity=Countries::class, inversedBy="country_accommodations")
     * @ORM\JoinColumn(nullable=true)
     */
    private $hebergementCountry;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="hebergementRelation")
     */
    private $departmentRelation;

    /**
     * @ORM\OneToMany(targetEntity=Media::class, mappedBy="media_relation")
     */
    private $media_relation;

    /**
     * @ORM\ManyToMany(targetEntity=Peculiarity::class, mappedBy="relation_hebergement")
     */
    private $relation_particularite;

    /**
     * @ORM\ManyToMany(targetEntity=Equipment::class, mappedBy="hebergement_equipment")
     */
    private $hebergement_equipment;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->media_relation = new ArrayCollection();
        $this->relation_particularite = new ArrayCollection();
        $this->hebergement_equipment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLieux(): ?string
    {
        return $this->lieux;
    }

    public function setLieux(string $lieux): self
    {
        $this->lieux = $lieux;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getLastUpdateDate(): ?\DateTimeInterface
    {
        return $this->lastUpdateDate;
    }

    public function setLastUpdateDate(\DateTimeInterface $lastUpdateDate): self
    {
        $this->lastUpdateDate = $lastUpdateDate;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getPromotion(): ?string
    {
        return $this->promotion;
    }

    public function setPromotion(?string $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getIsPromotional(): ?bool
    {
        return $this->isPromotional;
    }

    public function setIsPromotional(?bool $isPromotional): self
    {
        $this->isPromotional = $isPromotional;

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addHebergement($this);
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeHebergement($this);
        }

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
        return UploaderHelper::HEBERGEMENT_IMAGE.'/'.$this->getImage();
    }

    public function getTarif(): ?string
    {
        return $this->tarif;
    }

    public function setTarif(string $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getHebergementCountry(): ?Countries
    {
        return $this->hebergementCountry;
    }

    public function setHebergementCountry(?Countries $hebergementCountry): self
    {
        $this->hebergementCountry = $hebergementCountry;

        return $this;
    }

    public function getDepartmentRelation(): ?Department
    {
        return $this->departmentRelation;
    }

    public function setDepartmentRelation(?Department $departmentRelation): self
    {
        $this->departmentRelation = $departmentRelation;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMediaRelation(): Collection
    {
        return $this->media_relation;
    }

    public function addMediaRelation(Media $mediaRelation): self
    {
        if (!$this->media_relation->contains($mediaRelation)) {
            $this->media_relation[] = $mediaRelation;
            $mediaRelation->setMediaRelation($this);
        }

        return $this;
    }

    public function removeMediaRelation(Media $mediaRelation): self
    {
        if ($this->media_relation->removeElement($mediaRelation)) {
            // set the owning side to null (unless already changed)
            if ($mediaRelation->getMediaRelation() === $this) {
                $mediaRelation->setMediaRelation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Peculiarity>
     */
    public function getRelationParticularite(): Collection
    {
        return $this->relation_particularite;
    }

    public function addRelationParticularite(Peculiarity $relationParticularite): self
    {
        if (!$this->relation_particularite->contains($relationParticularite)) {
            $this->relation_particularite[] = $relationParticularite;
            $relationParticularite->addRelationHebergement($this);
        }

        return $this;
    }

    public function removeRelationParticularite(Peculiarity $relationParticularite): self
    {
        if ($this->relation_particularite->removeElement($relationParticularite)) {
            $relationParticularite->removeRelationHebergement($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Equipment>
     */
    public function getHebergementEquipment(): Collection
    {
        return $this->hebergement_equipment;
    }

    public function addHebergementEquipment(Equipment $hebergementEquipment): self
    {
        if (!$this->hebergement_equipment->contains($hebergementEquipment)) {
            $this->hebergement_equipment[] = $hebergementEquipment;
            $hebergementEquipment->addHebergementEquipment($this);
        }

        return $this;
    }

    public function removeHebergementEquipment(Equipment $hebergementEquipment): self
    {
        if ($this->hebergement_equipment->removeElement($hebergementEquipment)) {
            $hebergementEquipment->removeHebergementEquipment($this);
        }

        return $this;
    }


}
