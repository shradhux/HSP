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
}
