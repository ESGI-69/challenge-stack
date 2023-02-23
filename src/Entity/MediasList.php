<?php

namespace App\Entity;

use App\Repository\MediasListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation\Slug;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: MediasListRepository::class)]
#[Vich\Uploadable]
class MediasList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $release_date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path_cover = null;

    #[Vich\UploadableField(mapping: 'picture_clubs', fileNameProperty: 'path_cover')]
    private ?File $imageFile = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\ManyToMany(targetEntity: Media::class, mappedBy: 'mediaslists')]
    private Collection $medias;

    #[ORM\ManyToMany(targetEntity: Artist::class, inversedBy: 'medias')]
    private Collection $artists;

    #[ORM\Column(length: 105)]
    #[Slug(fields: ['type', 'id'])]
    private ?string $slug = null;

    public function __construct()
    {
        $this->artists = new ArrayCollection();
        $this->medias = new ArrayCollection();
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

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(\DateTimeInterface $release_date): self
    {
        $this->release_date = $release_date;

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

    public function getPathCover(): ?string
    {

        if ( $this->path_cover == "" ) {
            $this->path_cover = "placeholder-medias_lists.jpeg";
        }

        return $this->path_cover;
        
    }

    public function getPrefixedPathCover(): ?string
    {

        if ( $this->path_cover == "" ) {
            $this->path_cover = "placeholder-medias_lists.jpeg";
        }

        return "/data-files/medias_list-pictures/".$this->path_cover;
        
    }

    public function setPathCover(?string $path_cover): self
    {
        $this->path_cover = $path_cover;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return MediasList
     */
    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias->add($media);
            $media->addMediaslist($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->medias->removeElement($media)) {
            $media->removeMediaslist($this);
        }

        return $this;
    }

    public function getTotalDuration(): int
    {
        $total = 0;
        
        foreach ($this->medias as $media) {
            $total += $media->getDuree();
        }

        return $total;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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
}