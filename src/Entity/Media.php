<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use App\Service\UploaderHelper;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 */
class Media
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $media_alt;

    /**
     * @ORM\ManyToOne(targetEntity=Hebergement::class, inversedBy="media_relation")
     */
    private $media_relation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $media;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMediaAlt(): ?string
    {
        return $this->media_alt;
    }

    public function setMediaAlt(?string $media_alt): self
    {
        $this->media_alt = $media_alt;

        return $this;
    }

    public function getMediaRelation(): ?Hebergement
    {
        return $this->media_relation;
    }

    public function setMediaRelation(?Hebergement $media_relation): self
    {
        $this->media_relation = $media_relation;

        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(?string $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getMediaPath (){
        return UploaderHelper::MEDIA_IMAGE.'/'.$this->getMedia();
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
