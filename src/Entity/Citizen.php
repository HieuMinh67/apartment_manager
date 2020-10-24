<?php

namespace App\Entity;

use App\Repository\CitizenRepository;
use Doctrine\ORM\Mapping as ORM;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

/**
 * @ORM\Entity(repositoryClass=CitizenRepository::class)
 */
class Citizen
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $phone;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="smallint")
     */
    private $gender;

    /**
     * @ORM\OneToOne(targetEntity=Apartment::class, mappedBy="citizenId", cascade={"persist", "remove"})
     */
    private $apartmentId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getApartmentId(): ?Apartment
    {
        return $this->apartmentId;
    }

    public function setApartmentId(?Apartment $apartmentId): self
    {
        $this->apartmentId = $apartmentId;

        // set (or unset) the owning side of the relation if necessary
        $newCitizenId = null === $apartmentId ? null : $this;
        if ($apartmentId->getCitizenId() !== $newCitizenId) {
            $apartmentId->setCitizenId($newCitizenId);
        }

        return $this;
    }

    public function __toString() {
        return $this->getFirstName().' '.$this->getLastName();
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
