<?php

namespace App\Entity;

use App\Repository\PetToyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PetToyRepository::class)]
class ToyBoxToy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $price = null;

    #[ORM\ManyToOne(inversedBy: 'toyBoxToys')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ToyBox $toyBox = null;

    #[ORM\ManyToOne(inversedBy: 'toyBoxToys')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Toy $toy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getToyBox(): ?ToyBox
    {
        return $this->toyBox;
    }

    public function setToyBox(?ToyBox $toyBox): static
    {
        $this->toyBox = $toyBox;

        return $this;
    }

    public function getToy(): ?Toy
    {
        return $this->toy;
    }

    public function setToy(?Toy $toy): static
    {
        $this->toy = $toy;

        return $this;
    }
}
