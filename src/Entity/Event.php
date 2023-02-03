<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ticketing_link = null;

    #[ORM\ManyToMany(targetEntity: Artist::class, inversedBy: 'events')]
    private Collection $artists;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ConcertHall $id_concerthall = null;

    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $insterested_users;

    #[ORM\Column(length: 255)]
    private ?string $picture_path = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column]
    private ?int $duration = null;

    #[ORM\Column(length: 255)]
    #[Slug(fields: ['title'])]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function __construct()
    {
        $this->artists = new ArrayCollection();
        $this->insterested_users = new ArrayCollection();
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $date): self
    {
        $this->start_date = $date;

        return $this;
    }

    public function getTicketingLink(): ?string
    {
        return $this->ticketing_link;
    }

    public function setTicketingLink(?string $ticketing_link): self
    {
        $this->ticketing_link = $ticketing_link;

        return $this;
    }

    public function getIdConcerthall(): ?ConcertHall
    {
        return $this->id_concerthall;
    }

    public function setIdConcerthall(?ConcertHall $id_concerthall): self
    {
        $this->id_concerthall = $id_concerthall;

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
     * @return Collection<int, User>
     */
    public function getInsterestedUsers(): Collection
    {
        return $this->insterested_users;
    }

    public function addInsterestedUser(User $insterestedUser): self
    {
        if (!$this->insterested_users->contains($insterestedUser)) {
            $this->insterested_users->add($insterestedUser);
        }

        return $this;
    }

    public function removeInsterestedUser(User $insterestedUser): self
    {
        $this->insterested_users->removeElement($insterestedUser);

        return $this;
    }

    public function getPicturePath(): ?string
    {
        return $this->picture_path;
    }

    public function setPicturePath(string $picture_path): self
    {
        $this->picture_path = $picture_path;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
