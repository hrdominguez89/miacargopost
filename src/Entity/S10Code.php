<?php

namespace App\Entity;

use App\Repository\S10CodeRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: S10CodeRepository::class)]
class S10Code
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 's10codes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PostalServiceRange $postalServiceRange = null;

    #[ORM\Column(length: 2)]
    private ?string $serviceCode = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $numbercode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $barcodeImage = null;

    #[ORM\Column(length: 255)]
    private ?string $fromName = null;

    #[ORM\Column(length: 255)]
    private ?string $fromStreet = null;

    #[ORM\Column(length: 255)]
    private ?string $fromCity = null;

    #[ORM\Column(length: 25)]
    private ?string $fromPostcode = null;

    #[ORM\ManyToOne(inversedBy: 's10CodesFrom')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $fromCountry = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $fromTel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fromEmail = null;

    #[ORM\Column(length: 255)]
    private ?string $toName = null;

    #[ORM\Column(length: 255)]
    private ?string $toStreet = null;

    #[ORM\Column(length: 25)]
    private ?string $toPostcode = null;

    #[ORM\Column(length: 255)]
    private ?string $toCity = null;

    #[ORM\ManyToOne(inversedBy: 's10codesTo')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $toCountry = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $toTel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $toEmail = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameDesignatedOperator = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sendersCustomsReference = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $importersReference = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $importersTel = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $declarationIdentity = null;

    #[ORM\Column]
    private ?float $totalGrossWeight = null;

    #[ORM\Column]
    private ?float $totalValue = null;

    #[ORM\Column(nullable: true)]
    private ?float $acceptanceInfItemWeight = null;

    #[ORM\Column(nullable: true)]
    private ?float $acceptanceInfPostalChargesFees = null;

    #[ORM\Column(nullable: true)]
    private ?float $acceptanceInfInsurance = null;

    #[ORM\Column(nullable: true)]
    private ?float $acceptanceInfTotal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $acceptanceInfOffice = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $acceptanceInfDateTime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deliveryInformationDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $deliveryInformationPersonName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $deliveryInformationSignature = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categoryItemExplanation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comments = null;

    #[ORM\ManyToOne(inversedBy: 's10Codes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?CategoryDocument $categoryDocument = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categoryDocuentNumber = null;

    #[ORM\OneToMany(mappedBy: 's10code', targetEntity: ItemDetail::class)]
    private Collection $itemDetails;

    #[ORM\OneToMany(mappedBy: 's10code', targetEntity: CategoryItemS10code::class)]
    private Collection $categoryItemS10codes;

    #[ORM\ManyToOne(inversedBy: 's10Codes')]
    private ?Bags $bag = null;

    #[ORM\Column(length: 13, nullable: true)]
    private ?string $code = null;

    public function __construct()
    {
        $this->itemDetails = new ArrayCollection();
        $this->categoryItemS10codes = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getServiceCode(): ?string
    {
        return $this->serviceCode;
    }

    public function setServiceCode(string $serviceCode): static
    {
        $this->serviceCode = $serviceCode;

        return $this;
    }

    public function getNumbercode(): ?string
    {
        return $this->numbercode;
    }

    public function setNumbercode(string $numbercode): static
    {
        $this->numbercode = $numbercode;

        return $this;
    }

    public function getFormattedNumbercode(): string
    {
        return $this->serviceCode . str_pad($this->numbercode ?? '', 9, '0', STR_PAD_LEFT) . $this->toCountry->getIso2();
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

    public function getFromName(): ?string
    {
        return $this->fromName;
    }

    public function setFromName(string $fromName): static
    {
        $this->fromName = $fromName;

        return $this;
    }

    public function getFromStreet(): ?string
    {
        return $this->fromStreet;
    }

    public function setFromStreet(string $fromStreet): static
    {
        $this->fromStreet = $fromStreet;

        return $this;
    }

    public function getFromCity(): ?string
    {
        return $this->fromCity;
    }

    public function setFromCity(string $fromCity): static
    {
        $this->fromCity = $fromCity;

        return $this;
    }

    public function getFromPostcode(): ?string
    {
        return $this->fromPostcode;
    }

    public function setFromPostcode(string $fromPostcode): static
    {
        $this->fromPostcode = $fromPostcode;

        return $this;
    }

    public function getFromCountry(): ?Country
    {
        return $this->fromCountry;
    }

    public function setFromCountry(?Country $fromCountry): static
    {
        $this->fromCountry = $fromCountry;

        return $this;
    }

    public function getFromTel(): ?string
    {
        return $this->fromTel;
    }

    public function setFromTel(?string $fromTel): static
    {
        $this->fromTel = $fromTel;

        return $this;
    }

    public function getFromEmail(): ?string
    {
        return $this->fromEmail;
    }

    public function setFromEmail(?string $fromEmail): static
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    public function getToName(): ?string
    {
        return $this->toName;
    }

    public function setToName(string $toName): static
    {
        $this->toName = $toName;

        return $this;
    }

    public function getToStreet(): ?string
    {
        return $this->toStreet;
    }

    public function setToStreet(string $toStreet): static
    {
        $this->toStreet = $toStreet;

        return $this;
    }

    public function getToPostcode(): ?string
    {
        return $this->toPostcode;
    }

    public function setToPostcode(string $toPostcode): static
    {
        $this->toPostcode = $toPostcode;

        return $this;
    }

    public function getToCity(): ?string
    {
        return $this->toCity;
    }

    public function setToCity(string $toCity): static
    {
        $this->toCity = $toCity;

        return $this;
    }

    public function getToCountry(): ?Country
    {
        return $this->toCountry;
    }

    public function setToCountry(?Country $toCountry): static
    {
        $this->toCountry = $toCountry;

        return $this;
    }

    public function getToTel(): ?string
    {
        return $this->toTel;
    }

    public function setToTel(?string $toTel): static
    {
        $this->toTel = $toTel;

        return $this;
    }

    public function getToEmail(): ?string
    {
        return $this->toEmail;
    }

    public function setToEmail(?string $toEmail): static
    {
        $this->toEmail = $toEmail;

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

    public function getNameDesignatedOperator(): ?string
    {
        return $this->nameDesignatedOperator;
    }

    public function setNameDesignatedOperator(?string $nameDesignatedOperator): static
    {
        $this->nameDesignatedOperator = $nameDesignatedOperator;

        return $this;
    }

    public function getSendersCustomsReference(): ?string
    {
        return $this->sendersCustomsReference;
    }

    public function setSendersCustomsReference(?string $sendersCustomsReference): static
    {
        $this->sendersCustomsReference = $sendersCustomsReference;

        return $this;
    }

    public function getImportersReference(): ?string
    {
        return $this->importersReference;
    }

    public function setImportersReference(?string $importersReference): static
    {
        $this->importersReference = $importersReference;

        return $this;
    }

    public function getImportersTel(): ?string
    {
        return $this->importersTel;
    }

    public function setImportersTel(?string $importersTel): static
    {
        $this->importersTel = $importersTel;

        return $this;
    }

    public function getDeclarationIdentity(): ?string
    {
        return $this->declarationIdentity;
    }

    public function setDeclarationIdentity(?string $declarationIdentity): static
    {
        $this->declarationIdentity = $declarationIdentity;

        return $this;
    }

    public function getTotalGrossWeight(): ?float
    {
        return $this->totalGrossWeight;
    }

    public function setTotalGrossWeight(float $totalGrossWeight): static
    {
        $this->totalGrossWeight = $totalGrossWeight;

        return $this;
    }

    public function getTotalValue(): ?float
    {
        return $this->totalValue;
    }

    public function setTotalValue(float $totalValue): static
    {
        $this->totalValue = $totalValue;

        return $this;
    }

    public function getAcceptanceInfItemWeight(): ?float
    {
        return $this->acceptanceInfItemWeight;
    }

    public function setAcceptanceInfItemWeight(?float $acceptanceInfItemWeight): static
    {
        $this->acceptanceInfItemWeight = $acceptanceInfItemWeight;

        return $this;
    }

    public function getAcceptanceInfPostalChargesFees(): ?float
    {
        return $this->acceptanceInfPostalChargesFees;
    }

    public function setAcceptanceInfPostalChargesFees(float $acceptanceInfPostalChargesFees): static
    {
        $this->acceptanceInfPostalChargesFees = $acceptanceInfPostalChargesFees;

        return $this;
    }

    public function getAcceptanceInfInsurance(): ?float
    {
        return $this->acceptanceInfInsurance;
    }

    public function setAcceptanceInfInsurance(float $acceptanceInfInsurance): static
    {
        $this->acceptanceInfInsurance = $acceptanceInfInsurance;

        return $this;
    }

    public function getAcceptanceInfTotal(): ?float
    {
        return $this->acceptanceInfTotal;
    }

    public function setAcceptanceInfTotal(float $acceptanceInfTotal): static
    {
        $this->acceptanceInfTotal = $acceptanceInfTotal;

        return $this;
    }

    public function getAcceptanceInfOffice(): ?string
    {
        return $this->acceptanceInfOffice;
    }

    public function setAcceptanceInfOffice(string $acceptanceInfOffice): static
    {
        $this->acceptanceInfOffice = $acceptanceInfOffice;

        return $this;
    }

    public function getAcceptanceInfDateTime(): ?\DateTimeInterface
    {
        return $this->acceptanceInfDateTime;
    }

    public function setAcceptanceInfDateTime(?\DateTimeInterface $acceptanceInfDateTime): static
    {
        $this->acceptanceInfDateTime = $acceptanceInfDateTime;

        return $this;
    }

    public function getDeliveryInformationDate(): ?\DateTimeInterface
    {
        return $this->deliveryInformationDate;
    }

    public function setDeliveryInformationDate(?\DateTimeInterface $deliveryInformationDate): static
    {
        $this->deliveryInformationDate = $deliveryInformationDate;

        return $this;
    }

    public function getDeliveryInformationPersonName(): ?string
    {
        return $this->deliveryInformationPersonName;
    }

    public function setDeliveryInformationPersonName(?string $deliveryInformationPersonName): static
    {
        $this->deliveryInformationPersonName = $deliveryInformationPersonName;

        return $this;
    }

    public function getDeliveryInformationSignature(): ?string
    {
        return $this->deliveryInformationSignature;
    }

    public function setDeliveryInformationSignature(?string $deliveryInformationSignature): static
    {
        $this->deliveryInformationSignature = $deliveryInformationSignature;

        return $this;
    }

    public function getCategoryItemExplanation(): ?string
    {
        return $this->categoryItemExplanation;
    }

    public function setCategoryItemExplanation(?string $categoryItemExplanation): static
    {
        $this->categoryItemExplanation = $categoryItemExplanation;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): static
    {
        $this->comments = $comments;

        return $this;
    }

    public function getCategoryDocument(): ?CategoryDocument
    {
        return $this->categoryDocument;
    }

    public function setCategoryDocument(?CategoryDocument $categoryDocument): static
    {
        $this->categoryDocument = $categoryDocument;

        return $this;
    }

    /**
     * @return Collection<int, ItemDetail>
     */
    public function getItemDetails(): Collection
    {
        return $this->itemDetails;
    }

    public function addItemDetail(ItemDetail $itemDetail): static
    {
        if (!$this->itemDetails->contains($itemDetail)) {
            $this->itemDetails->add($itemDetail);
            $itemDetail->setS10code($this);
        }

        return $this;
    }

    public function removeItemDetail(ItemDetail $itemDetail): static
    {
        if ($this->itemDetails->removeElement($itemDetail)) {
            // set the owning side to null (unless already changed)
            if ($itemDetail->getS10code() === $this) {
                $itemDetail->setS10code(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CategoryItemS10code>
     */
    public function getCategoryItemS10codes(): Collection
    {
        return $this->categoryItemS10codes;
    }

    public function addCategoryItemS10code(CategoryItemS10code $categoryItemS10code): static
    {
        if (!$this->categoryItemS10codes->contains($categoryItemS10code)) {
            $this->categoryItemS10codes->add($categoryItemS10code);
            $categoryItemS10code->setS10code($this);
        }

        return $this;
    }

    public function removeCategoryItemS10code(CategoryItemS10code $categoryItemS10code): static
    {
        if ($this->categoryItemS10codes->removeElement($categoryItemS10code)) {
            // set the owning side to null (unless already changed)
            if ($categoryItemS10code->getS10code() === $this) {
                $categoryItemS10code->setS10code(null);
            }
        }

        return $this;
    }

    public function getCategoryDocuentNumber(): ?string
    {
        return $this->categoryDocuentNumber;
    }

    public function setCategoryDocuentNumber(?string $categoryDocuentNumber): static
    {
        $this->categoryDocuentNumber = $categoryDocuentNumber;

        return $this;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }
}
