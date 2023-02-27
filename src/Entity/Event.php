<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[Vich\Uploadable]
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
    #[ORM\JoinColumn(nullable: false, onDelete:"CASCADE")]
    private ?ConcertHall $id_concerthall = null;

    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $insterested_users;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture_path = null;

    #[Vich\UploadableField(mapping: 'picture_events', fileNameProperty: 'picture_path')]
    private ?File $imageFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column]
    private ?bool $private = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'id_event', targetEntity: EventInvite::class, cascade: ['remove'])]
    private Collection $eventInvites;

    #[ORM\Column(length: 255)]
    #[Slug(fields: ['title','id'])]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'created_events')]
    #[ORM\JoinColumn(nullable: false, onDelete:"CASCADE")]
    private ?Artist $ArtistAuthor = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    public function __construct()
    {
        $this->artists = new ArrayCollection();
        $this->insterested_users = new ArrayCollection();
        $this->eventInvites = new ArrayCollection();
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

    public function getPrefixedPicturePath(): ?string
    {

        if ( $this->picture_path == "" ) {
            return "/data-files/event-pictures/placeholder-events.png";
        }

        return "/data-files/event-pictures/".$this->picture_path;

    }

    public function setPicturePath(?string $picture_path): self
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

    public function isPrivate(): ?bool
    {
        return $this->private;
    }

    public function setPrivate(bool $private): self
    {
        $this->private = $private;

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
     * @return Collection<int, EventInvite>
     */
    public function getEventInvites(): Collection
    {
        return $this->eventInvites;
    }

    public function addEventInvite(EventInvite $eventInvite): self
    {
        if (!$this->eventInvites->contains($eventInvite)) {
            $this->eventInvites->add($eventInvite);
            $eventInvite->setIdEvent($this);
        }

        return $this;
    }

    public function removeEventInvite(EventInvite $eventInvite): self
    {
        if ($this->eventInvites->removeElement($eventInvite)) {
            // set the owning side to null (unless already changed)
            if ($eventInvite->getIdEvent() === $this) {
                $eventInvite->setIdEvent(null);
            }
        }

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

    public function getArtistAuthor(): ?Artist
    {
        return $this->ArtistAuthor;
    }

    public function setArtistAuthor(?Artist $ArtistAuthor): self
    {
        $this->ArtistAuthor = $ArtistAuthor;

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

        if ($imageFile instanceof UploadedFile) {

            $this->updated_at = new \DateTime();
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
