<?php

namespace App\Entity;

use App\Repository\StatusBagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusBagRepository::class)]
class StatusBag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 6)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: Bags::class)]
    private Collection $bags;

    public function __construct()
    {
        $this->bags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $bag->setStatus($this);
        }

        return $this;
    }

    public function removeBag(Bags $bag): static
    {
        if ($this->bags->removeElement($bag)) {
            // set the owning side to null (unless already changed)
            if ($bag->getStatus() === $this) {
                $bag->setStatus(null);
            }
        }

        return $this;
    }
}
