<?php

namespace App\Entity;

use App\Repository\RoutesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoutesRepository::class)]
class Routes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    

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

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $effectiveFrom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $validUntil = null;

    #[ORM\OneToMany(mappedBy: 'Route', targetEntity: Dispatch::class)]
    private Collection $dispatches;

    public function __construct()
    {
        $this->segments = new ArrayCollection();
        $this->routeServiceRanges = new ArrayCollection();
        $this->dispatches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEffectiveFrom(): ?\DateTimeInterface
    {
        return $this->effectiveFrom;
    }

    public function setEffectiveFrom(\DateTimeInterface $effectiveFrom): static
    {
        $this->effectiveFrom = $effectiveFrom;

        return $this;
    }

    public function getValidUntil(): ?\DateTimeInterface
    {
        return $this->validUntil;
    }

    public function setValidUntil(\DateTimeInterface $validUntil): static
    {
        $this->validUntil = $validUntil;

        return $this;
    }

    /**
     * @return Collection<int, Dispatch>
     */
    public function getDispatches(): Collection
    {
        return $this->dispatches;
    }

    public function addDispatch(Dispatch $dispatch): static
    {
        if (!$this->dispatches->contains($dispatch)) {
            $this->dispatches->add($dispatch);
            $dispatch->setRoute($this);
        }

        return $this;
    }

    public function removeDispatch(Dispatch $dispatch): static
    {
        if ($this->dispatches->removeElement($dispatch)) {
            // set the owning side to null (unless already changed)
            if ($dispatch->getRoute() === $this) {
                $dispatch->setRoute(null);
            }
        }

        return $this;
    }
}
