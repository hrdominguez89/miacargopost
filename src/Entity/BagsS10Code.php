<?php

namespace App\Entity;

use App\Repository\BagsS10CodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BagsS10CodeRepository::class)]
class BagsS10Code
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'bagsS10Codes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bags $bag = null;

    #[ORM\ManyToOne(inversedBy: 'bagsS10Codes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?S10Code $s10Code = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBag(): ?Bags
    {
        return $this->bag;
    }

    public function setBag(?Bags $bag): static
    {
        $this->bag = $bag;

        return $this;
    }

    public function getS10Code(): ?S10Code
    {
        return $this->s10Code;
    }

    public function setS10Code(?S10Code $s10Code): static
    {
        $this->s10Code = $s10Code;

        return $this;
    }
}
