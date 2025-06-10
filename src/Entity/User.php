<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private bool $admin = false;

    #[ORM\Column]
    private ?string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\OneToMany(targetEntity: Media::class, mappedBy: 'user', cascade: ['remove'], orphanRemoval: true)]
    private Collection $medias;

    #[ORM\Column(length: 255)]
    private string $password;
    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(type: 'boolean')]
    private bool $isActive = true;

    public function __construct()
    {
        $this->medias = new ArrayCollection();
        $this->roles = ['ROLE_USER'];
        $this->isActive = true;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function setMedias(Collection $medias): void
    {
        $this->medias = $medias;
    }

    public function isAdmin(): bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): void
    {
        $this->admin = $admin;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function eraseCredentials(){}

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function isActive(): bool {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self {
        $this->isActive = $isActive;
        return $this;
    }
}
