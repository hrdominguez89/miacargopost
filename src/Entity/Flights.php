<?php

namespace App\Entity;

use App\Repository\FlightsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Validator\Constraints as AppAssert;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FlightsRepository::class)]
#[AppAssert\DifferentAirports]
#[AppAssert\UniqueFlight]
#[ORM\UniqueConstraint(
    name: "unique_flight",
    columns: ["origin_airport", "arrival_airport", "flight_frequency", "departure_time", "arrival_time", "aircraft_type", "flight_number", "effective_date", "discontinue_date"]
)]
class Flights
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3)]
    #[Assert\NotBlank]
    private ?string $originAirport = null;

    #[ORM\Column(length: 3)]
    #[Assert\NotBlank]
    private ?string $arrivalAirport = null;

    #[ORM\Column(length: 7)]
    private ?string $flightNumber = null;

    #[ORM\Column(length: 7)]
    private ?string $flightFrequency = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $departureTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $arrivalTime = null;

    #[ORM\Column(length: 6)]
    private ?string $aircraftType = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $effectiveDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $discontinueDate = null;

    #[ORM\OneToMany(mappedBy: 'flight', targetEntity: Segments::class)]
    private Collection $segments;

    public function __construct()
    {
        $this->segments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOriginAirport(): ?string
    {
        return $this->originAirport;
    }

    public function setOriginAirport(string $originAirport): static
    {
        $this->originAirport = $originAirport;

        return $this;
    }

    public function getArrivalAirport(): ?string
    {
        return $this->arrivalAirport;
    }

    public function setArrivalAirport(string $arrivalAirport): static
    {
        $this->arrivalAirport = $arrivalAirport;

        return $this;
    }

    public function getFlightNumber(): ?string
    {
        return $this->flightNumber;
    }

    public function setFlightNumber(string $flightNumber): static
    {
        $this->flightNumber = $flightNumber;

        return $this;
    }

    public function getFlightFrequency(): ?string
    {
        return $this->flightFrequency;
    }

    public function setFlightFrequency(string $flightFrequency): static
    {
        $this->flightFrequency = $flightFrequency;

        return $this;
    }

    public function getDepartureTime(): ?\DateTimeInterface
    {
        return $this->departureTime;
    }

    public function setDepartureTime(\DateTimeInterface $departureTime): static
    {
        $this->departureTime = $departureTime;

        return $this;
    }

    public function getArrivalTime(): ?\DateTimeInterface
    {
        return $this->arrivalTime;
    }

    public function setArrivalTime(\DateTimeInterface $arrivalTime): static
    {
        $this->arrivalTime = $arrivalTime;

        return $this;
    }

    public function getAircraftType(): ?string
    {
        return $this->aircraftType;
    }

    public function setAircraftType(string $aircraftType): static
    {
        $this->aircraftType = $aircraftType;

        return $this;
    }

    public function getEffectiveDate(): ?\DateTimeInterface
    {
        return $this->effectiveDate;
    }

    public function setEffectiveDate(\DateTimeInterface $effectiveDate): static
    {
        $this->effectiveDate = $effectiveDate;

        return $this;
    }

    public function getDiscontinueDate(): ?\DateTimeInterface
    {
        return $this->discontinueDate;
    }

    public function setDiscontinueDate(\DateTimeInterface $discontinueDate): static
    {
        $this->discontinueDate = $discontinueDate;

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
            $segment->setFlight($this);
        }

        return $this;
    }

    public function removeSegment(Segments $segment): static
    {
        if ($this->segments->removeElement($segment)) {
            // set the owning side to null (unless already changed)
            if ($segment->getFlight() === $this) {
                $segment->setFlight(null);
            }
        }

        return $this;
    }
}
