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
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[Vich\Uploadable]
class User implements UserInterface, PasswordAuthenticatedUserInterface, \Serializable
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
    #[NotBlank]
    #[Length(min: 6)]
    private ?string $plainPassword = null;

    #[ORM\ManyToOne]
    private ?Artist $id_artist = null;

    #[ORM\ManyToMany(targetEntity: Artist::class, mappedBy: 'followed')]
    private Collection $artists_followed;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profile_picture_path = null;

    #[Vich\UploadableField(mapping: 'picture_users', fileNameProperty: 'profile_picture_path')]
    private ?File $imageFile = null;

    public function __construct()
    {
        $this->artists_followed = new ArrayCollection();
        $this->artists = new ArrayCollection();
    }
    #[ORM\Column(length: 255)]
    private ?string $activation_token = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $activation_token_expiration = null;

    #[ORM\Column]
    private ?bool $active = false;

    #[ORM\Column(length: 128, unique: true)]
    private ?string $username = null;

    #[ORM\OneToMany(mappedBy: 'id_manager', targetEntity: Artist::class)]
    private Collection $artists;

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

    public function getPrefixedProfilePicturePath(): ?string
    {

        if ( $this->profile_picture_path == "" ) {
            return "/data-files/user-pictures/placeholder-image.jpeg";
        }

        return "/data-files/user-pictures/".$this->profile_picture_path;
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

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


    public function serialize() {

        if ( !is_null($this->id_artist) ) {
            $this->id_artist->setImageFile(null);
        }

        return serialize(array(
            $this->id,
            $this->email,
            $this->roles,
            $this->password,
            $this->plainPassword,
            $this->id_artist,
            $this->artists_followed,
            $this->profile_picture_path,
        ));
        
    }
        
    public function unserialize($serialized) {
        
        list (
            $this->id,
            $this->email,
            $this->roles,
            $this->password,
            $this->plainPassword,
            $this->id_artist,
            $this->artists_followed,
            $this->profile_picture_path,
        ) = unserialize($serialized);
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
            $artist->setIdManager($this);
        }

        return $this;
    }

    public function removeArtist(Artist $artist): self
    {
        if ($this->artists->removeElement($artist)) {
            // set the owning side to null (unless already changed)
            if ($artist->getIdManager() === $this) {
                $artist->setIdManager(null);
            }
        }

        return $this;
    }
}
