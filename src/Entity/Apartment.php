<?php

namespace App\Entity;

use App\Repository\ApartmentRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\False_;

/**
 * @ORM\Entity(repositoryClass=ApartmentRepository::class)
 */
class Apartment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $area;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\OneToOne(targetEntity=Citizen::class, inversedBy="apartmentId", cascade={"persist", "remove"})
     */
    private $citizenId;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Building::class, inversedBy="apartment")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $building;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    public function __construct()
    {
        $this->setUpdateAt(new \DateTime());
        if ($this->getCreateAt() === null)
        {
            $this->setCreateAt(new \DateTime());
            $this->setStatus(false);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(int $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCitizenId(): ?Citizen
    {
        return $this->citizenId;
    }

    public function setCitizenId(?Citizen $citizenId): self
    {
        $this->citizenId = $citizenId;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getBuilding(): ?Building
    {
        return $this->building;
    }

    public function setBuilding(?Building $building): self
    {
        $this->building = $building;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function __toString()
    {
        return $this->getId()."-".$this->getBuilding()->getName();
    }
}
