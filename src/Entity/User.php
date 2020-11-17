<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Vich\Uploadable
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    private $thumbnail;

    /**
     * @Vich\UploadableField(mapping="employee_image", fileNameProperty="thumbnail")
     */
    private $thumbnailFile;
    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updateAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\OneToMany(targetEntity=Quotation::class, mappedBy="archiveBy")
     */
    private $quotations;

    /**
     * @ORM\OneToMany(targetEntity=Timesheets::class, mappedBy="userId")
     */
    private $timesheets;

    public function __construct()
    {
        $this->updateAt = new \DateTime();
        if ($this->createAt === null) {
            $this->createAt = new \DateTime();
        }
        $this->quotations = new ArrayCollection();
        $this->timesheets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    /**
     * @param string|null $thumbnail
     */
    public function setThumbnail(?string $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return mixed
     */
    public function getThumbnailFile()
    {
        return $this->thumbnailFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $thumbnailFile
     */
    public function setThumbnailFile(?File $thumbnailFile = null): void
    {
        $this->thumbnailFile = $thumbnailFile;
        if (null !== $thumbnailFile) {
            $this->updateAt = new \DateTimeImmutable();
        }
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        if (sizeof($roles) == 0) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function addQuotation(Quotation $quotation): self
    {
        if (!$this->quotations->contains($quotation)) {
            $this->quotations[] = $quotation;
            $quotation->setArchiveBy($this);
        }

        return $this;
    }

    public function removeQuotation(Quotation $quotation): self
    {
        if ($this->quotations->contains($quotation)) {
            $this->quotations->removeElement($quotation);
            // set the owning side to null (unless already changed)
            if ($quotation->getArchiveBy() === $this) {
                $quotation->setArchiveBy(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getId()." - ".$this->getFirstName()." ".$this->getLastName();
    }

    /**
     * @return Collection|Timesheets[]
     */
    public function getTimesheets(): Collection
    {
        return $this->timesheets;
    }

    public function addTimesheet(Timesheets $timesheet): self
    {
        if (!$this->timesheets->contains($timesheet)) {
            $this->timesheets[] = $timesheet;
            $timesheet->setUserId($this);
        }

        return $this;
    }

    public function removeTimesheet(Timesheets $timesheet): self
    {
        if ($this->timesheets->contains($timesheet)) {
            $this->timesheets->removeElement($timesheet);
            // set the owning side to null (unless already changed)
            if ($timesheet->getUserId() === $this) {
                $timesheet->setUserId(null);
            }
        }

        return $this;
    }
}
