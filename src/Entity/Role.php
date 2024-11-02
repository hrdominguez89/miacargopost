<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[ORM\Table(name: '`tb_role`')]
#[UniqueEntity('name')]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(name: 'role_key', type: 'string', length: 100, unique: true)]
    #[Assert\Length(min: 2, max: 100)]
    #[Assert\NotBlank]
    private ?string $roleKey = null;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    #[Assert\Length(min: 2, max: 100)]
    #[Assert\NotBlank]
    private ?string $name = null;


    #[ORM\Column(name: 'date_created', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCreated;

    #[ORM\Column(name: 'date_updated', type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpdated;

    public function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->dateUpdated = new \DateTime();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): Role
    {
        $name = str_replace(["ROLE", "ROL"], "", strtoupper($name));

        $this->name = strtoupper($name);

        $this->roleKey = 'ROLE_'.strtoupper(str_replace(" ", "_", $name));

        return $this;
    }

    /**
     * @return bool
     */
    public function isSecurityRole(): bool
    {
        return in_array(
            $this->getRoleKey(),
            ['ROLE_ADMIN', 'ROLE_EMPLOYEE', 'ROLE_API', 'ROLE_DEFAULT', 'ROLE_ALLOWED_TO_SWITCH']
        );
    }

    /**
     * @return string|null
     */
    public function getRoleKey(): ?string
    {
        return $this->roleKey;
    }

    /**
     * @param string|null $roleKey
     *
     * @return $this
     */
    public function setRoleKey(?string $roleKey): Role
    {
        $this->roleKey = $roleKey;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTimeInterface|null $dateCreated
     * @return $this
     */
    public function setDateCreated(?\DateTimeInterface $dateCreated): Role
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateUpdated(): ?\DateTimeInterface
    {
        return $this->dateUpdated;
    }

    /**
     * @param \DateTimeInterface|null $dateUpdated
     * @return $this
     */
    public function setDateUpdated(?\DateTimeInterface $dateUpdated): self
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name ?: '';
    }


}
