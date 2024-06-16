<?php

namespace App\Entity;

use App\Repository\PetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PetRepository::class)]
class Pet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $age = null;

    #[ORM\ManyToOne(inversedBy: 'pets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Owner $owner = null;

    /**
     * @var Collection<int, PetToy>
     */
    #[ORM\OneToMany(targetEntity: PetToy::class, mappedBy: 'pet', cascade: ['persist', 'remove'], orphanRemoval: true)]
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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): static
    {
        $this->owner = $owner;

        return $this;
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
            $petToy->setPet($this);
        }

        return $this;
    }

    public function removePetToy(PetToy $petToy): static
    {
        if ($this->petToys->removeElement($petToy)) {
            // set the owning side to null (unless already changed)
            if ($petToy->getPet() === $this) {
                $petToy->setPet(null);
            }
        }

        return $this;
    }
}
