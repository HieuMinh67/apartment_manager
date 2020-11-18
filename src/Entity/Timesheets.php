<?php

namespace App\Entity;

use App\Repository\TimesheetsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TimesheetsRepository::class)
 */
class Timesheets
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="timesheets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $EmployeeId;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startAt;

    /**
     * @ORM\Column(type="datetime", nullable=True)
     */
    private $endAt;

    public function __construct()
    {
        $this->startAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeId(): ?Employee
    {
        return $this->EmployeeId;
    }

    public function setEmployeeId(?Employee $EmployeeId): self
    {
        $this->EmployeeId = $EmployeeId;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * @param mixed $endAt
     */
    public function setEndAt($endAt): void
    {
        $this->endAt = $endAt;
    }
}
