<?php

namespace App\Entity;

use App\Repository\AmphitheatreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AmphitheatreRepository::class)]
class Amphitheatre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $place_libre = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaceLibre(): ?int
    {
        return $this->place_libre;
    }

    public function setPlaceLibre(?int $place_libre): static
    {
        $this->place_libre = $place_libre;

        return $this;
    }

    public function __toString()
    {
        return $this->getPlaceLibre();
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }
}
