<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    // NotBlank with groups create
    #[NotBlank(groups: ['create'])]
    #[Length(min: 6)]
    private ?string $plainPassword = null;

    #[ORM\ManyToOne]
    private ?Artist $id_artist = null;

    #[ORM\ManyToMany(targetEntity: Artist::class, mappedBy: 'followed')]
    private Collection $artists_followed;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profile_picture_path = null;

    public function __construct()
    {
        $this->artists_followed = new ArrayCollection();
    }
    #[ORM\Column(length: 255)]
    private ?string $activation_token = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $activation_token_expiration = null;

    #[ORM\Column]
    private ?bool $active = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     * @return User
     */
    public function setPlainPassword(?string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;

        if (null !== $plainPassword) {
            $this->updatedAT = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    /**
     * @return Collection<int, Artist>
     */
    public function getArtistsFollowed(): Collection
    {
        return $this->artists_followed;
    }

    public function addArtistsFollowed(Artist $artistsFollowed): self
    {
        if (!$this->artists_followed->contains($artistsFollowed)) {
            $this->artists_followed->add($artistsFollowed);
            $artistsFollowed->addFollowed($this);
        }

        return $this;
    }
    
    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(string $activation_token): self
    {
        $this->activation_token = $activation_token;

        return $this;
    }

    public function removeArtistsFollowed(Artist $artistsFollowed): self
    {
        if ($this->artists_followed->removeElement($artistsFollowed)) {
            $artistsFollowed->removeFollowed($this);
        }

        return $this;
    }
    
    public function getActivationTokenExpiration(): ?\DateTimeInterface
    {
        return $this->activation_token_expiration;
    }

    public function setActivationTokenExpiration(\DateTimeInterface $activation_token_expiration): self
    {
        $this->activation_token_expiration = $activation_token_expiration;

        return $this;
    }

    public function getProfilePicturePath(): ?string
    {
        return $this->profile_picture_path;
    }

    public function setProfilePicturePath(?string $profile_picture_path): self
    {
        $this->profile_picture_path = $profile_picture_path;

        return $this;
    }
    
    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
