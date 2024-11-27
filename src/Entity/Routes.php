<?php

namespace App\Entity;

use App\Repository\RoutesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoutesRepository::class)]
class Routes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'routes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PostalService $postalService = null;

    #[ORM\ManyToOne(inversedBy: 'originOfficeRoutes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offices $originOffice = null;

    #[ORM\ManyToOne(inversedBy: 'destinationOfficeRoutes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offices $destinationOffice = null;

    #[ORM\OneToMany(mappedBy: 'route', targetEntity: Segments::class)]
    private Collection $segments;

    #[ORM\OneToMany(mappedBy: 'routes', targetEntity: RouteServiceRange::class)]
    private Collection $routeServiceRanges;

    public function __construct()
    {
        $this->segments = new ArrayCollection();
        $this->routeServiceRanges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostalService(): ?PostalService
    {
        return $this->postalService;
    }

    public function setPostalService(?PostalService $postalService): static
    {
        $this->postalService = $postalService;

        return $this;
    }

    public function getOriginOffice(): ?Offices
    {
        return $this->originOffice;
    }

    public function setOriginOffice(?Offices $originOffice): static
    {
        $this->originOffice = $originOffice;

        return $this;
    }

    public function getDestinationOffice(): ?Offices
    {
        return $this->destinationOffice;
    }

    public function setDestinationOffice(?Offices $destinationOffice): static
    {
        $this->destinationOffice = $destinationOffice;

        return $this;
    }

    /**
     * @return Collection<int, Segments>
     */
    public function getSegments(): Collection
    {
        return $this->segments;
    }

    public function addSegment(Segments $segment): static
    {
        if (!$this->segments->contains($segment)) {
            $this->segments->add($segment);
            $segment->setRoute($this);
        }

        return $this;
    }

    public function removeSegment(Segments $segment): static
    {
        if ($this->segments->removeElement($segment)) {
            // set the owning side to null (unless already changed)
            if ($segment->getRoute() === $this) {
                $segment->setRoute(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RouteServiceRange>
     */
    public function getRouteServiceRanges(): Collection
    {
        return $this->routeServiceRanges;
    }

    public function addRouteServiceRange(RouteServiceRange $routeServiceRange): static
    {
        if (!$this->routeServiceRanges->contains($routeServiceRange)) {
            $this->routeServiceRanges->add($routeServiceRange);
            $routeServiceRange->setRoutes($this);
        }

        return $this;
    }

    public function removeRouteServiceRange(RouteServiceRange $routeServiceRange): static
    {
        if ($this->routeServiceRanges->removeElement($routeServiceRange)) {
            // set the owning side to null (unless already changed)
            if ($routeServiceRange->getRoutes() === $this) {
                $routeServiceRange->setRoutes(null);
            }
        }

        return $this;
    }
}
