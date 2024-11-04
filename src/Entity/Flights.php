<?php

namespace App\Entity;

use App\Repository\FlightsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlightsRepository::class)]
class Flights
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3)]
    private ?string $originAirport = null;

    #[ORM\Column(length: 3)]
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
}
