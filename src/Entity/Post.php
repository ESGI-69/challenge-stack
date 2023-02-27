<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation\Slug;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text_content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true, onDelete:"CASCADE")]
    private ?User $id_user = null;

    #[ORM\ManyToOne]
    private ?Media $id_media = null;

    #[ORM\ManyToOne]
    private ?MediasList $id_mediaslist = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true, onDelete:"CASCADE")]
    private ?Event $id_event = null;

    #[ORM\Column(length: 105)]
    #[Slug(fields: ['title', 'id'])]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'id_post', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $validated_at = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false, onDelete:"CASCADE")]
    private ?Artist $id_artist = null;

    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $userslike;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->userslike = new ArrayCollection();
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

    public function getTextContent(): ?string
    {
        return $this->text_content;
    }

    public function setTextContent(string $text_content): self
    {
        $this->text_content = $text_content;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdMedia(): ?Media
    {
        return $this->id_media;
    }

    public function setIdMedia(?Media $id_media): self
    {
        $this->id_media = $id_media;

        return $this;
    }

    public function getIdMediaslist(): ?MediasList
    {
        return $this->id_mediaslist;
    }

    public function setIdMediaslist(?MediasList $id_mediaslist): self
    {
        $this->id_mediaslist = $id_mediaslist;

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

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setIdPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getIdPost() === $this) {
                $comment->setIdPost(null);
            }
        }

        return $this;
    }

    public function getValidatedAt(): ?\DateTimeInterface
    {
        return $this->validated_at;
    }

    public function setValidatedAt(?\DateTimeInterface $validated_at): self
    {
        $this->validated_at = $validated_at;

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
     * @return Collection<int, User>
     */
    public function getUserslike(): Collection
    {
        return $this->userslike;
    }

    public function addUserslike(User $userslike): self
    {
        if (!$this->userslike->contains($userslike)) {
            $this->userslike->add($userslike);
        }

        return $this;
    }

    public function removeUserslike(User $userslike): self
    {
        $this->userslike->removeElement($userslike);

        return $this;
    }
}
