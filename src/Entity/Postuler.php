<?php

namespace App\Entity;

use App\Repository\PostulerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostulerRepository::class)]
class Postuler
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?RendezVous $rendez_vous = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?OffreEmploi $OffreEmploi = null;

    #[ORM\ManyToOne(inversedBy: 'postulers')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRendezVous(): ?RendezVous
    {
        return $this->rendez_vous;
    }

    public function setRendezVous(RendezVous $rendez_vous): static
    {
        $this->rendez_vous = $rendez_vous;

        return $this;
    }

    public function getOffreEmploi(): ?OffreEmploi
    {
        return $this->OffreEmploi;
    }

    public function setOffreEmploi(?OffreEmploi $OffreEmploi): static
    {
        $this->OffreEmploi = $OffreEmploi;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
