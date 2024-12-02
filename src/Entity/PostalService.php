<?php

namespace App\Entity;

use App\Repository\PostalServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostalServiceRepository::class)]
class PostalService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'postalServices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PostalProduct $postalProduct = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'postalService', targetEntity: PostalServiceRange::class)]
    private Collection $postalServiceRanges;

    #[ORM\Column]
    private ?bool $requiresBilateralAgreement = null;

    public function __construct()
    {
        $this->postalServiceRanges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostalProduct(): ?PostalProduct
    {
        return $this->postalProduct;
    }

    public function setPostalProduct(?PostalProduct $postalProduct): static
    {
        $this->postalProduct = $postalProduct;

        return $this;
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
     * @return Collection<int, PostalServiceRange>
     */
    public function getPostalServiceRanges(): Collection
    {
        return $this->postalServiceRanges;
    }

    public function addPostalServiceRange(PostalServiceRange $postalServiceRange): static
    {
        if (!$this->postalServiceRanges->contains($postalServiceRange)) {
            $this->postalServiceRanges->add($postalServiceRange);
            $postalServiceRange->setPostalService($this);
        }

        return $this;
    }

    public function removePostalServiceRange(PostalServiceRange $postalServiceRange): static
    {
        if ($this->postalServiceRanges->removeElement($postalServiceRange)) {
            // set the owning side to null (unless already changed)
            if ($postalServiceRange->getPostalService() === $this) {
                $postalServiceRange->setPostalService(null);
            }
        }

        return $this;
    }

    public function isRequiresBilateralAgreement(): ?bool
    {
        return $this->requiresBilateralAgreement;
    }

    public function setRequiresBilateralAgreement(bool $requiresBilateralAgreement): static
    {
        $this->requiresBilateralAgreement = $requiresBilateralAgreement;

        return $this;
    }
}
