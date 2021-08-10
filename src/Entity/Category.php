<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Gazouillis::class, mappedBy="category")
     */
    private $gazouillis;

    public function __construct()
    {
        $this->allGazouillis= new ArrayCollection();
        $this->gazouillis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Gazouillis[]
     */
    public function getGazouillis(): Collection
    {
        return $this->gazouillis;
    }

    public function addGazouilli(Gazouillis $gazouilli): self
    {
        if (!$this->gazouillis->contains($gazouilli)) {
            $this->gazouillis[] = $gazouilli;
            $gazouilli->setCategory($this);
        }

        return $this;
    }

    public function removeGazouilli(Gazouillis $gazouilli): self
    {
        if ($this->gazouillis->removeElement($gazouilli)) {
            // set the owning side to null (unless already changed)
            if ($gazouilli->getCategory() === $this) {
                $gazouilli->setCategory(null);
            }
        }

        return $this;
    }

}
