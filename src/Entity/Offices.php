<?php

namespace App\Entity;

use App\Repository\OfficesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OfficesRepository::class)]
class Offices
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 6)]
    private ?string $impcCode = null;

    #[ORM\Column(length: 12)]
    private ?string $impcShortName = null;

    #[ORM\Column(length: 12)]
    private ?string $OrganisationShortName = null;

    #[ORM\Column(length: 35)]
    private ?string $impcCodeFullName = null;

    #[ORM\Column(length: 35)]
    private ?string $organisationFullName = null;

    #[ORM\Column(length: 3)]
    private ?string $impcOrganisationCode = null;

    #[ORM\Column(length: 8)]
    private ?string $partyIdentifier = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $function = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $validFrom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $validTo = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $mailFlowInbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $mailFlowOutbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $mailFlowClosedTransit = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $categoryAInbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $categoryBInbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $categoryCInbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $categoryDInbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $CategoryAOutbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $categoryBOutbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $categoryCOutbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $categoryDOutbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $mailClassUInbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $mailClassCInbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $mailClassEInbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $mailClassTInbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $mailClassUOutbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $mailClassCOutbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $mailClassEOutbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $mailClassTOutbound = null;

    #[ORM\Column(length: 1, nullable: true)]
    private ?string $specialType = null;

    #[ORM\Column(length: 3, nullable: true)]
    private ?string $bilateralAgreement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $specialRestrictions = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImpcCode(): ?string
    {
        return $this->impcCode;
    }

    public function setImpcCode(string $impcCode): static
    {
        $this->impcCode = $impcCode;

        return $this;
    }

    public function getImpcShortName(): ?string
    {
        return $this->impcShortName;
    }

    public function setImpcShortName(string $impcShortName): static
    {
        $this->impcShortName = $impcShortName;

        return $this;
    }

    public function getOrganisationShortName(): ?string
    {
        return $this->OrganisationShortName;
    }

    public function setOrganisationShortName(string $OrganisationShortName): static
    {
        $this->OrganisationShortName = $OrganisationShortName;

        return $this;
    }

    public function getImpcCodeFullName(): ?string
    {
        return $this->impcCodeFullName;
    }

    public function setImpcCodeFullName(string $impcCodeFullName): static
    {
        $this->impcCodeFullName = $impcCodeFullName;

        return $this;
    }

    public function getOrganisationFullName(): ?string
    {
        return $this->organisationFullName;
    }

    public function setOrganisationFullName(string $organisationFullName): static
    {
        $this->organisationFullName = $organisationFullName;

        return $this;
    }

    public function getImpcOrganisationCode(): ?string
    {
        return $this->impcOrganisationCode;
    }

    public function setImpcOrganisationCode(string $impcOrganisationCode): static
    {
        $this->impcOrganisationCode = $impcOrganisationCode;

        return $this;
    }

    public function getPartyIdentifier(): ?string
    {
        return $this->partyIdentifier;
    }

    public function setPartyIdentifier(string $partyIdentifier): static
    {
        $this->partyIdentifier = $partyIdentifier;

        return $this;
    }

    public function getFunction(): ?string
    {
        return $this->function;
    }

    public function setFunction(?string $function): static
    {
        $this->function = $function;

        return $this;
    }

    public function getValidFrom(): ?\DateTimeInterface
    {
        return $this->validFrom;
    }

    public function setValidFrom(\DateTimeInterface $validFrom): static
    {
        $this->validFrom = $validFrom;

        return $this;
    }

    public function getValidTo(): ?\DateTimeInterface
    {
        return $this->validTo;
    }

    public function setValidTo(?\DateTimeInterface $validTo): static
    {
        $this->validTo = $validTo;

        return $this;
    }

    public function getMailFlowInbound(): ?string
    {
        return $this->mailFlowInbound;
    }

    public function setMailFlowInbound(?string $mailFlowInbound): static
    {
        $this->mailFlowInbound = $mailFlowInbound;

        return $this;
    }

    public function getMailFlowOutbound(): ?string
    {
        return $this->mailFlowOutbound;
    }

    public function setMailFlowOutbound(?string $mailFlowOutbound): static
    {
        $this->mailFlowOutbound = $mailFlowOutbound;

        return $this;
    }

    public function getMailFlowClosedTransit(): ?string
    {
        return $this->mailFlowClosedTransit;
    }

    public function setMailFlowClosedTransit(?string $mailFlowClosedTransit): static
    {
        $this->mailFlowClosedTransit = $mailFlowClosedTransit;

        return $this;
    }

    public function getCategoryAInbound(): ?string
    {
        return $this->categoryAInbound;
    }

    public function setCategoryAInbound(?string $categoryAInbound): static
    {
        $this->categoryAInbound = $categoryAInbound;

        return $this;
    }

    public function getCategoryBInbound(): ?string
    {
        return $this->categoryBInbound;
    }

    public function setCategoryBInbound(?string $categoryBInbound): static
    {
        $this->categoryBInbound = $categoryBInbound;

        return $this;
    }

    public function getCategoryCInbound(): ?string
    {
        return $this->categoryCInbound;
    }

    public function setCategoryCInbound(?string $categoryCInbound): static
    {
        $this->categoryCInbound = $categoryCInbound;

        return $this;
    }

    public function getCategoryDInbound(): ?string
    {
        return $this->categoryDInbound;
    }

    public function setCategoryDInbound(?string $categoryDInbound): static
    {
        $this->categoryDInbound = $categoryDInbound;

        return $this;
    }

    public function getCategoryAOutbound(): ?string
    {
        return $this->CategoryAOutbound;
    }

    public function setCategoryAOutbound(?string $CategoryAOutbound): static
    {
        $this->CategoryAOutbound = $CategoryAOutbound;

        return $this;
    }

    public function getCategoryBOutbound(): ?string
    {
        return $this->categoryBOutbound;
    }

    public function setCategoryBOutbound(?string $categoryBOutbound): static
    {
        $this->categoryBOutbound = $categoryBOutbound;

        return $this;
    }

    public function getCategoryCOutbound(): ?string
    {
        return $this->categoryCOutbound;
    }

    public function setCategoryCOutbound(?string $categoryCOutbound): static
    {
        $this->categoryCOutbound = $categoryCOutbound;

        return $this;
    }

    public function getCategoryDOutbound(): ?string
    {
        return $this->categoryDOutbound;
    }

    public function setCategoryDOutbound(?string $categoryDOutbound): static
    {
        $this->categoryDOutbound = $categoryDOutbound;

        return $this;
    }

    public function getMailClassUInbound(): ?string
    {
        return $this->mailClassUInbound;
    }

    public function setMailClassUInbound(?string $mailClassUInbound): static
    {
        $this->mailClassUInbound = $mailClassUInbound;

        return $this;
    }

    public function getMailClassCInbound(): ?string
    {
        return $this->mailClassCInbound;
    }

    public function setMailClassCInbound(?string $mailClassCInbound): static
    {
        $this->mailClassCInbound = $mailClassCInbound;

        return $this;
    }

    public function getMailClassEInbound(): ?string
    {
        return $this->mailClassEInbound;
    }

    public function setMailClassEInbound(?string $mailClassEInbound): static
    {
        $this->mailClassEInbound = $mailClassEInbound;

        return $this;
    }

    public function getMailClassTInbound(): ?string
    {
        return $this->mailClassTInbound;
    }

    public function setMailClassTInbound(?string $mailClassTInbound): static
    {
        $this->mailClassTInbound = $mailClassTInbound;

        return $this;
    }

    public function getMailClassUOutbound(): ?string
    {
        return $this->mailClassUOutbound;
    }

    public function setMailClassUOutbound(?string $mailClassUOutbound): static
    {
        $this->mailClassUOutbound = $mailClassUOutbound;

        return $this;
    }

    public function getMailClassCOutbound(): ?string
    {
        return $this->mailClassCOutbound;
    }

    public function setMailClassCOutbound(?string $mailClassCOutbound): static
    {
        $this->mailClassCOutbound = $mailClassCOutbound;

        return $this;
    }

    public function getMailClassEOutbound(): ?string
    {
        return $this->mailClassEOutbound;
    }

    public function setMailClassEOutbound(?string $mailClassEOutbound): static
    {
        $this->mailClassEOutbound = $mailClassEOutbound;

        return $this;
    }

    public function getMailClassTOutbound(): ?string
    {
        return $this->mailClassTOutbound;
    }

    public function setMailClassTOutbound(?string $mailClassTOutbound): static
    {
        $this->mailClassTOutbound = $mailClassTOutbound;

        return $this;
    }

    public function getSpecialType(): ?string
    {
        return $this->specialType;
    }

    public function setSpecialType(?string $specialType): static
    {
        $this->specialType = $specialType;

        return $this;
    }

    public function getBilateralAgreement(): ?string
    {
        return $this->bilateralAgreement;
    }

    public function setBilateralAgreement(?string $bilateralAgreement): static
    {
        $this->bilateralAgreement = $bilateralAgreement;

        return $this;
    }

    public function getSpecialRestrictions(): ?string
    {
        return $this->specialRestrictions;
    }

    public function setSpecialRestrictions(?string $specialRestrictions): static
    {
        $this->specialRestrictions = $specialRestrictions;

        return $this;
    }
}
