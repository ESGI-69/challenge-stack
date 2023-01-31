<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
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
}
