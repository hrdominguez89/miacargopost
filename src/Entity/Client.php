<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $typeDocument = null;
    
    #[ORM\Column(length: 50)]
    private ?string $document = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 15)]
    private ?string $telephone = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Address::class, cascade: ['persist','remove'])]
    private Collection $clientAddresses;

   

    public function __construct()
    {
        $this->clientAddresses = new ArrayCollection();
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

    public function getTypeDocument(): ?string
    {
        return $this->typeDocument;
    }

    public function setTypeDocument(string $typeDocument): static
    {
        $this->typeDocument = $typeDocument;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getClientAddresses(): Collection
    {
        return $this->clientAddresses;
    }

    public function addClientAddress(Address $clientAddress): static
    {
        if (!$this->clientAddresses->contains($clientAddress)) {
            $this->clientAddresses->add($clientAddress);
            $clientAddress->setClient($this);
        }

        return $this;
    }

    public function removeClientAddress(Address $clientAddress): static
    {
        if ($this->clientAddresses->removeElement($clientAddress)) {
            // set the owning side to null (unless already changed)
            if ($clientAddress->getClient() === $this) {
                $clientAddress->setClient(null);
            }
        }

        return $this;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(string $document): static
    {
        $this->document = $document;

        return $this;
    }
    public static function loadValidatorMetadata(ClassMetadata $metadata){
        $metadata->addPropertyConstraint('name', new Assert\NotBlank(
            ['message' => 'Por favor ingresar nombre' ]));
            $metadata->addPropertyConstraint('typeDocument', new Assert\NotBlank(
                ['message' => 'Por favor ingrese tipo de documento' ]));
            $metadata->addPropertyConstraint('document', new Assert\NotBlank(
                ['message' => 'Por favor ingrese el documento' ]));
            $metadata->addPropertyConstraint('email', new Assert\NotBlank(
                ['message' => 'Por favor ingrese un email' ]));
            $metadata->addPropertyConstraint('telephone', new Assert\NotBlank(
                ['message' => 'Por favor ingrese un telefono' ]));
            
        /* $metadata->addConstraint(new UniqueEntity([
                'fields' => 'impcCode',
                'message' => 'Valida impc Code ingresado ya que es único',
                
            ])); */
    }


}
