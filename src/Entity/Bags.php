<?php

namespace App\Entity;

use App\Repository\BagsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BagsRepository::class)]
class Bags
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bags')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Dispatch $dispatch = null;

    #[ORM\Column]
    private ?int $numberBag = null;

    #[ORM\Column]
    private ?bool $isFinalBag = null;

    #[ORM\Column]
    private ?bool $isCertified = null;

    #[ORM\Column]
    private ?int $weight = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'bags')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StatusBag $status = null;

    #[ORM\OneToMany(mappedBy: 'bag', targetEntity: BagsS10Code::class)]
    private Collection $bagsS10Codes;

    public function __construct()
    {
        $this->bagsS10Codes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDispatch(): ?Dispatch
    {
        return $this->dispatch;
    }

    public function setDispatch(?Dispatch $dispatch): static
    {
        $this->dispatch = $dispatch;

        return $this;
    }

    public function getNumberBag(): ?int
    {
        return $this->numberBag;
    }

    public function setNumberBag(int $numberBag): static
    {
        $this->numberBag = $numberBag;

        return $this;
    }

    public function isIsFinalBag(): ?bool
    {
        return $this->isFinalBag;
    }

    public function setIsFinalBag(bool $isFinalBag): static
    {
        $this->isFinalBag = $isFinalBag;

        return $this;
    }

    public function isIsCertified(): ?bool
    {
        return $this->isCertified;
    }

    public function setIsCertified(bool $isCertified): static
    {
        $this->isCertified = $isCertified;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): static
    {
        $this->weight = $weight;

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

    public function getStatus(): ?StatusBag
    {
        return $this->status;
    }

    public function setStatus(?StatusBag $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, BagsS10Code>
     */
    public function getBagsS10Codes(): Collection
    {
        return $this->bagsS10Codes;
    }

    public function addBagsS10Code(BagsS10Code $bagsS10Code): static
    {
        if (!$this->bagsS10Codes->contains($bagsS10Code)) {
            $this->bagsS10Codes->add($bagsS10Code);
            $bagsS10Code->setBag($this);
        }

        return $this;
    }

    public function removeBagsS10Code(BagsS10Code $bagsS10Code): static
    {
        if ($this->bagsS10Codes->removeElement($bagsS10Code)) {
            // set the owning side to null (unless already changed)
            if ($bagsS10Code->getBag() === $this) {
                $bagsS10Code->setBag(null);
            }
        }

        return $this;
    }
}
