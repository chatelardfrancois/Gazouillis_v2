<?php

namespace App\Entity;

use App\Repository\GazouillisRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GazouillisRepository::class)
 */
class Gazouillis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Champ obligatoire")
     * @Assert\Length(min="1", max= "250", minMessage="Trop court (3min)", maxMessage="Trop long (65535max)")
     * @ORM\Column(type="text", length=250, nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @Assert\NotBlank(message="Champ obligatoire")
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="gazouillis")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="allGazouillis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getIsPublished()
    {
        return $this->isPublished;
    }

    public function setIsPublished($isPublished): self
    {
        $this->isPublished = $isPublished;
        return $this;
    }

    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function setDateCreated($dateCreated): self
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
