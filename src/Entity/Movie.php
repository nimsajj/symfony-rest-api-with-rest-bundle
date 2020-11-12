<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $isan;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $runtime;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="datetime")
     */
    private $realeaseAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsan(): ?string
    {
        return $this->isan;
    }

    public function setIsan(string $isan): self
    {
        $this->isan = $isan;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRuntime(): ?string
    {
        return $this->runtime;
    }

    public function setRuntime(string $runtime): self
    {
        $this->runtime = $runtime;

        return $this;
    }

    public function getRating(): ?string
    {
        return $this->rating;
    }

    public function setRating(?string $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getRealeaseAt(): ?\DateTimeInterface
    {
        return $this->realeaseAt;
    }

    public function setRealeaseAt(\DateTimeInterface $realeaseAt): self
    {
        $this->realeaseAt = $realeaseAt;

        return $this;
    }
}
