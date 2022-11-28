<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AuthorRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ApiResource()
 */
class Author
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $title = null;

    /**
     * @ORM\Column(type="date")
     */
    private ?\DateTimeInterface $birthday = null;

    /**
     * @ORM\Column(type="text")
     */
    private ?string $bio = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $active = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $created = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?\DateTimeInterface $modified = null;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getModified(): ?\DateTimeInterface
    {
        return $this->modified;
    }

    public function setModified(\DateTimeInterface $modified): self
    {
        $this->modified = $modified;

        return $this;
    }

    public function __construct() {
        $currentTimestamp = new \DateTime();
        $this->created = $currentTimestamp;
        $this->modified = $currentTimestamp;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateTimestamp(){
        $currentTimestamp = new \DateTime();

        $this->modified = $currentTimestamp;

        if(is_null($this->getCreated())){
            $this->setCreated($currentTimestamp);
        }
    }
}
