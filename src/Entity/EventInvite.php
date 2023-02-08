<?php

namespace App\Entity;

use App\Repository\EventInviteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventInviteRepository::class)]
class EventInvite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'eventInvites')]
    private ?Event $id_event = null;

    #[ORM\ManyToOne(inversedBy: 'eventInvites')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artist $id_artist = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'eventInvitesCreated')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artist $ArtistAuthor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getIdEvent(): ?Event
    {
        return $this->id_event;
    }

    public function setIdEvent(?Event $id_event): self
    {
        $this->id_event = $id_event;

        return $this;
    }

    public function getIdArtist(): ?Artist
    {
        return $this->id_artist;
    }

    public function setIdArtist(?Artist $id_artist): self
    {
        $this->id_artist = $id_artist;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getArtistAuthor(): ?Artist
    {
        return $this->ArtistAuthor;
    }

    public function setArtistAuthor(?Artist $ArtistAuthor): self
    {
        $this->ArtistAuthor = $ArtistAuthor;

        return $this;
    }
}
