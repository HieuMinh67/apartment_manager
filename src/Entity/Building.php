<?php

namespace App\Entity;

use App\Repository\BuildingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BuildingRepository::class)
 */
class Building
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
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberOfAppartment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=Apartment::class, mappedBy="building", orphanRemoval=true)
     */
    private $apartment;

    /**
     * @ORM\OneToMany(targetEntity=Quotation::class, mappedBy="building", orphanRemoval=true)
     */
    private $quotation;

    public function __construct()
    {
        $this->apartment = new ArrayCollection();
        $this->quotation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNumberOfAppartment(): ?int
    {
        return $this->numberOfAppartment;
    }

    public function setNumberOfAppartment(int $numberOfAppartment): self
    {
        $this->numberOfAppartment = $numberOfAppartment;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Apartment[]
     */
    public function getApartment(): Collection
    {
        return $this->apartment;
    }

    public function addApartment(Apartment $apartment): self
    {
        if (!$this->apartment->contains($apartment)) {
            $this->apartment[] = $apartment;
            $apartment->setBuilding($this);
        }

        return $this;
    }

    public function removeApartment(Apartment $apartment): self
    {
        if ($this->apartment->contains($apartment)) {
            $this->apartment->removeElement($apartment);
            // set the owning side to null (unless already changed)
            if ($apartment->getBuilding() === $this) {
                $apartment->setBuilding(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Quotation[]
     */
    public function getQuotation(): Collection
    {
        return $this->quotation;
    }

    public function addQuotation(Quotation $quotation): self
    {
        if (!$this->quotation->contains($quotation)) {
            $this->quotation[] = $quotation;
            $quotation->setBuilding($this);
        }

        return $this;
    }

    public function removeQuotation(Quotation $quotation): self
    {
        if ($this->quotation->contains($quotation)) {
            $this->quotation->removeElement($quotation);
            // set the owning side to null (unless already changed)
            if ($quotation->getBuilding() === $this) {
                $quotation->setBuilding(null);
            }
        }

        return $this;
    }



    public function __toString()
    {
        return $this->getName() . " - " . $this->getAddress();
    }
}
