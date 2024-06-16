<?php

namespace App\Entity;

use App\Repository\ToyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ToyRepository::class)]
class Toy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, PetToy>
     */
    #[ORM\OneToMany(targetEntity: PetToy::class, mappedBy: 'toy', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $petToys;

    public function __construct()
    {
        $this->petToys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return Collection<int, PetToy>
     */
    public function getPetToys(): Collection
    {
        return $this->petToys;
    }

    public function addPetToy(PetToy $petToy): static
    {
        if (!$this->petToys->contains($petToy)) {
            $this->petToys->add($petToy);
            $petToy->setToy($this);
        }

        return $this;
    }

    public function removePetToy(PetToy $petToy): static
    {
        if ($this->petToys->removeElement($petToy)) {
            // set the owning side to null (unless already changed)
            if ($petToy->getToy() === $this) {
                $petToy->setToy(null);
            }
        }

        return $this;
    }
}
