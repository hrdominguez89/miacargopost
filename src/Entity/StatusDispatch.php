<?php

namespace App\Entity;

use App\Repository\StatusDispatchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusDispatchRepository::class)]
class StatusDispatch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'statusDispatch', targetEntity: Dispatch::class)]
    private Collection $dispatches;

    public function __construct()
    {
        $this->dispatches = new ArrayCollection();
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
            $dispatch->setStatusDispatch($this);
        }

        return $this;
    }

    public function removeDispatch(Dispatch $dispatch): static
    {
        if ($this->dispatches->removeElement($dispatch)) {
            // set the owning side to null (unless already changed)
            if ($dispatch->getStatusDispatch() === $this) {
                $dispatch->setStatusDispatch(null);
            }
        }

        return $this;
    }
}
