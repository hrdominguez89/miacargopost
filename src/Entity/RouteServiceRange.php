<?php

namespace App\Entity;

use App\Repository\RouteServiceRangeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RouteServiceRangeRepository::class)]
class RouteServiceRange
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'routeServiceRanges')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Routes $routes = null;

    #[ORM\ManyToOne(inversedBy: 'routeServiceRanges')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PostalServiceRange $serviceRange = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoutes(): ?Routes
    {
        return $this->routes;
    }

    public function setRoutes(?Routes $routes): static
    {
        $this->routes = $routes;

        return $this;
    }

    public function getServiceRange(): ?PostalServiceRange
    {
        return $this->serviceRange;
    }

    public function setServiceRange(?PostalServiceRange $serviceRange): static
    {
        $this->serviceRange = $serviceRange;

        return $this;
    }
}
