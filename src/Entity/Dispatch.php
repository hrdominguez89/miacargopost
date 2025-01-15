<?php

namespace App\Entity;

use App\Repository\DispatchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DispatchRepository::class)]
class Dispatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'originOfficeDispatches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offices $originOffice = null;

    #[ORM\ManyToOne(inversedBy: 'destinationOfficeDispatches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offices $destinationOffice = null;

    #[ORM\ManyToOne(inversedBy: 'dispatches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PostalServiceRange $postalServiceRange = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'dispatches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StatusDispatch $statusDispatch = null;

    #[ORM\ManyToOne(inversedBy: 'dispatches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Routes $Route = null;

    #[ORM\Column(length: 20)]
    private ?string $dispatchCode = null;

    #[ORM\OneToMany(mappedBy: 'dispatch', targetEntity: Bags::class)]
    private Collection $bags;

    #[ORM\Column]
    private ?int $numberDispatch = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $itinerary = null;

    #[ORM\Column(nullable: false)]
    private ?float $weight = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $barcodeImage = null;

    public function __construct()
    {
        $this->bags = new ArrayCollection();
        $this->createdAt =  new \DateTime();
        $this->updatedAt =  new \DateTime();
        $this->weight = 0;
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

    public function getPostalServiceRange(): ?PostalServiceRange
    {
        return $this->postalServiceRange;
    }

    public function setPostalServiceRange(?PostalServiceRange $postalServiceRange): static
    {
        $this->postalServiceRange = $postalServiceRange;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getStatusDispatch(): ?StatusDispatch
    {
        return $this->statusDispatch;
    }

    public function setStatusDispatch(?StatusDispatch $statusDispatch): static
    {
        $this->statusDispatch = $statusDispatch;

        return $this;
    }

    public function getRoute(): ?Routes
    {
        return $this->Route;
    }

    public function setRoute(?Routes $Route): static
    {
        $this->Route = $Route;

        return $this;
    }

    public function getDispatchCode(): ?string
    {
        return $this->dispatchCode;
    }

    public function setDispatchCode(string $dispatchCode): static
    {
        $this->dispatchCode = $dispatchCode;

        return $this;
    }

    /**
     * @return Collection<int, Bags>
     */
    public function getBags(): Collection
    {
        return $this->bags;
    }

    public function addBag(Bags $bag): static
    {
        if (!$this->bags->contains($bag)) {
            $this->bags->add($bag);
            $bag->setDispatch($this);
        }

        return $this;
    }

    public function removeBag(Bags $bag): static
    {
        if ($this->bags->removeElement($bag)) {
            // set the owning side to null (unless already changed)
            if ($bag->getDispatch() === $this) {
                $bag->setDispatch(null);
            }
        }

        return $this;
    }

    public function getNumberDispatch(): ?int
    {
        return $this->numberDispatch;
    }

    public function setNumberDispatch(int $numberDispatch): static
    {
        $this->numberDispatch = $numberDispatch;

        return $this;
    }

    public function getItinerary(): ?string
    {
        return $this->itinerary;
    }

    public function setItinerary(string $itinerary): static
    {
        $this->itinerary = $itinerary;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getBarcodeImage(): ?string
    {
        return $this->barcodeImage;
    }

    public function setBarcodeImage(?string $barcodeImage): static
    {
        $this->barcodeImage = $barcodeImage;

        return $this;
    }
}
