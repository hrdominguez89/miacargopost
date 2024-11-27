<?php

namespace App\Entity;

use App\Repository\SegmentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SegmentsRepository::class)]
class Segments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'segments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Routes $route = null;

    #[ORM\ManyToOne(inversedBy: 'segments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Flights $flight = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoute(): ?Routes
    {
        return $this->route;
    }

    public function setRoute(?Routes $route): static
    {
        $this->route = $route;

        return $this;
    }

    public function getFlight(): ?Flights
    {
        return $this->flight;
    }

    public function setFlight(?Flights $flight): static
    {
        $this->flight = $flight;

        return $this;
    }
}
