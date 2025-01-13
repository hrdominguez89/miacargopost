<?php

namespace App\Entity;

use App\Repository\PostalServiceRangeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostalServiceRangeRepository::class)]
class PostalServiceRange
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'postalServiceRanges')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PostalService $postalService = null;

    #[ORM\Column(length: 1)]
    private ?string $principalCharacter = null;

    #[ORM\Column(length: 1)]
    private ?string $secondCharacterFrom = null;

    #[ORM\Column(length: 1)]
    private ?string $secondCharacterTo = null;

    #[ORM\OneToMany(mappedBy: 'postalServiceRange', targetEntity: S10Code::class)]
    private Collection $s10codes;

    #[ORM\OneToMany(mappedBy: 'serviceRange', targetEntity: RouteServiceRange::class)]
    private Collection $routeServiceRanges;

    #[ORM\OneToMany(mappedBy: 'postalServiceRange', targetEntity: Dispatch::class)]
    private Collection $dispatches;

    public function __construct()
    {
        $this->s10codes = new ArrayCollection();
        $this->routeServiceRanges = new ArrayCollection();
        $this->dispatches = new ArrayCollection();
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

    public function getPrincipalCharacter(): ?string
    {
        return $this->principalCharacter;
    }

    public function setPrincipalCharacter(string $principalCharacter): static
    {
        $this->principalCharacter = $principalCharacter;

        return $this;
    }

    public function getSecondCharacterFrom(): ?string
    {
        return $this->secondCharacterFrom;
    }

    public function setSecondCharacterFrom(string $secondCharacterFrom): static
    {
        $this->secondCharacterFrom = $secondCharacterFrom;

        return $this;
    }

    public function getSecondCharacterTo(): ?string
    {
        return $this->secondCharacterTo;
    }

    public function setSecondCharacterTo(string $secondCharacterTo): static
    {
        $this->secondCharacterTo = $secondCharacterTo;

        return $this;
    }

    /**
     * @return Collection<int, S10Code>
     */
    public function gets10codes(): Collection
    {
        return $this->s10codes;
    }

    public function addS10codes(S10Code $s10codes): static
    {
        if (!$this->s10codes->contains($s10codes)) {
            $this->s10codes->add($s10codes);
            $s10codes->setPostalServiceRange($this);
        }

        return $this;
    }

    public function removeS10codes(S10Code $s10codes): static
    {
        if ($this->s10codes->removeElement($s10codes)) {
            // set the owning side to null (unless already changed)
            if ($s10codes->getPostalServiceRange() === $this) {
                $s10codes->setPostalServiceRange(null);
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
            $routeServiceRange->setServiceRange($this);
        }

        return $this;
    }

    public function removeRouteServiceRange(RouteServiceRange $routeServiceRange): static
    {
        if ($this->routeServiceRanges->removeElement($routeServiceRange)) {
            // set the owning side to null (unless already changed)
            if ($routeServiceRange->getServiceRange() === $this) {
                $routeServiceRange->setServiceRange(null);
            }
        }

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
            $dispatch->setPostalServiceRange($this);
        }

        return $this;
    }

    public function removeDispatch(Dispatch $dispatch): static
    {
        if ($this->dispatches->removeElement($dispatch)) {
            // set the owning side to null (unless already changed)
            if ($dispatch->getPostalServiceRange() === $this) {
                $dispatch->setPostalServiceRange(null);
            }
        }

        return $this;
    }

}
