<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=15, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $usertag;

    /**
     * @ORM\Column(type="text", length=160, nullable=true)
     */
    private $bio;

    /**
     * @ORM\OneToMany(targetEntity=Gazouillis::class, mappedBy="user")
     */
    private $allGazouillis;

    public function __construct()
    {
        $this->allGazouillis = new ArrayCollection();
    }

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
    public function getUsername(): string
    {
        return (string) $this->username;
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
     * @see UserInterface
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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUsertag(): ?string
    {
        return $this->usertag;
    }

    public function setUsertag(string $usertag): self
    {
        $this->usertag = $usertag;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * @return Collection|Gazouillis[]
     */
    public function getAllGazouillis(): Collection
    {
        return $this->allGazouillis;
    }

    public function addAllGazouilli(Gazouillis $allGazouilli): self
    {
        if (!$this->allGazouillis->contains($allGazouilli)) {
            $this->allGazouillis[] = $allGazouilli;
            $allGazouilli->setUser($this);
        }

        return $this;
    }

    public function removeAllGazouilli(Gazouillis $allGazouilli): self
    {
        if ($this->allGazouillis->removeElement($allGazouilli)) {
            // set the owning side to null (unless already changed)
            if ($allGazouilli->getUser() === $this) {
                $allGazouilli->setUser(null);
            }
        }

        return $this;
    }
}
