<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column(nullable: true)]
    private ?int $duree = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $file_path = null;

    #[ORM\ManyToMany(targetEntity: Artist::class, inversedBy: 'medias')]
    private Collection $artists;

    #[ORM\ManyToMany(targetEntity: MediasList::class)]
    private Collection $mediaslists;

    public function __construct()
    {
        $this->artists = new ArrayCollection();
        $this->mediaslists = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getFilePath(): ?string
    {
        if ( $this->file_path == "" ) {
          $this->file_path = "placeholder-medias_lists.jpeg";
        }
        return "/data-files/medias_list-pictures/".$this->file_path;
    }

    public function setFilePath(?string $file_path): self
    {
        $this->file_path = $file_path;

        return $this;
    }

    /**
     * @return Collection<int, Artist>
     */
    public function getArtists(): Collection
    {
        return $this->artists;
    }

    public function addArtist(Artist $artist): self
    {
        if (!$this->artists->contains($artist)) {
            $this->artists->add($artist);
        }

        return $this;
    }

    public function removeArtist(Artist $artist): self
    {
        $this->artists->removeElement($artist);

        return $this;
    }

    /**
     * @return Collection<int, MediasList>
     */
    public function getMediaslists(): Collection
    {
        return $this->mediaslists;
    }

    public function addMediaslist(MediasList $mediaslist): self
    {
        if (!$this->mediaslists->contains($mediaslist)) {
            $this->mediaslists->add($mediaslist);
        }

        return $this;
    }

    public function removeMediaslist(MediasList $mediaslist): self
    {
        $this->mediaslists->removeElement($mediaslist);

        return $this;
    }
}
