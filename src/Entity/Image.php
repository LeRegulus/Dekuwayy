<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
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
    private $imageUr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Anounce::class, inversedBy="images")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $anounce;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageUr(): ?string
    {
        return $this->imageUr;
    }

    public function setImageUr(string $imageUr): self
    {
        $this->imageUr = $imageUr;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAnounce(): ?Anounce
    {
        return $this->anounce;
    }

    public function setAnounce(?Anounce $anounce): self
    {
        $this->anounce = $anounce;

        return $this;
    }
}
