<?php

namespace App\Entity;

use App\Repository\BuildingRepository;
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
}
