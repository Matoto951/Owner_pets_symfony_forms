<?php

namespace App\Entity;

use App\Repository\ToyBoxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ToyBoxRepository::class)]
class ToyBox
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'toyBoxes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pet $pet = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, ToyBoxToy>
     */
    #[ORM\OneToMany(targetEntity: ToyBoxToy::class, mappedBy: 'toyBox', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $toyBoxToys;

    public function __construct()
    {
        $this->toyBoxToys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPet(): ?Pet
    {
        return $this->pet;
    }

    public function setPet(?Pet $pet): static
    {
        $this->pet = $pet;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ToyBoxToy>
     */
    public function getToyBoxToys(): Collection
    {
        return $this->toyBoxToys;
    }

    public function addToyBoxToy(ToyBoxToy $toyBoxToy): static
    {
        if (!$this->toyBoxToys->contains($toyBoxToy)) {
            $this->toyBoxToys->add($toyBoxToy);
            $toyBoxToy->setToyBox($this);
        }

        return $this;
    }

    public function removeToyBoxToy(ToyBoxToy $toyBoxToy): static
    {
        if ($this->toyBoxToys->removeElement($toyBoxToy)) {
            // set the owning side to null (unless already changed)
            if ($toyBoxToy->getToyBox() === $this) {
                $toyBoxToy->setToyBox(null);
            }
        }

        return $this;
    }
}
