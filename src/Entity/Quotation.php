<?php

namespace App\Entity;

use App\Repository\QuotationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuotationRepository::class)
 */
class Quotation
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
     * @ORM\Column(type="string", length=15)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\OneToMany(targetEntity=Building::class, mappedBy="quotation")
     */
    private $building;

    public function __construct()
    {
        $this->building = new ArrayCollection();
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return Collection|Building[]
     */
    public function getBuilding(): Collection
    {
        return $this->building;
    }

    public function addBuilding(Building $building): self
    {
        if (!$this->building->contains($building)) {
            $this->building[] = $building;
            $building->setQuotation($this);
        }

        return $this;
    }

    public function removeBuilding(Building $building): self
    {
        if ($this->building->contains($building)) {
            $this->building->removeElement($building);
            // set the owning side to null (unless already changed)
            if ($building->getQuotation() === $this) {
                $building->setQuotation(null);
            }
        }

        return $this;
    }
}
