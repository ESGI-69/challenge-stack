<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $pseudo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url_yt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url_soundcloud = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url_spotify = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url_deezer = null;

    #[ORM\ManyToMany(targetEntity: Media::class, mappedBy: 'artists')]
    private Collection $medias;

    #[ORM\ManyToMany(targetEntity: Event::class, mappedBy: 'artists')]
    private Collection $events;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'artists_followed')]
    private Collection $followed;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture_path = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    public function __construct()
    {
        $this->medias = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->followed = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUrlYt(): ?string
    {
        return $this->url_yt;
    }

    public function setUrlYt(?string $url_yt): self
    {
        $this->url_yt = $url_yt;

        return $this;
    }

    public function getUrlSoundcloud(): ?string
    {
        return $this->url_soundcloud;
    }

    public function setUrlSoundcloud(?string $url_soundcloud): self
    {
        $this->url_soundcloud = $url_soundcloud;

        return $this;
    }

    public function getUrlSpotify(): ?string
    {
        return $this->url_spotify;
    }

    public function setUrlSpotify(?string $url_spotify): self
    {
        $this->url_spotify = $url_spotify;

        return $this;
    }

    public function getUrlDeezer(): ?string
    {
        return $this->url_deezer;
    }

    public function setUrlDeezer(?string $url_deezer): self
    {
        $this->url_deezer = $url_deezer;

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
            $media->addArtist($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->medias->removeElement($media)) {
            $media->removeArtist($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->addArtist($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeArtist($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFollowed(): Collection
    {
        return $this->followed;
    }

    public function addFollowed(User $followed): self
    {
        if (!$this->followed->contains($followed)) {
            $this->followed->add($followed);
        }

        return $this;
    }

    public function removeFollowed(User $followed): self
    {
        $this->followed->removeElement($followed);

        return $this;
    }

    public function getPicturePath(): ?string
    {
        return $this->picture_path;
    }

    public function setPicturePath(?string $picture_path): self
    {
        $this->picture_path = $picture_path;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

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

}
