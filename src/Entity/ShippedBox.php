<?php

namespace App\Entity;

use App\Repository\ShippedBoxRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShippedBoxRepository::class)
 */
class ShippedBox
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
    private $courier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tracking;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label_image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourier(): ?string
    {
        return $this->courier;
    }

    public function setCourier(string $courier): self
    {
        $this->courier = $courier;

        return $this;
    }

    public function getTracking(): ?string
    {
        return $this->tracking;
    }

    public function setTracking(string $tracking): self
    {
        $this->tracking = $tracking;

        return $this;
    }

    public function getLabelImage(): ?string
    {
        return $this->label_image;
    }

    public function setLabelImage(string $label_image): self
    {
        $this->label_image = $label_image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
