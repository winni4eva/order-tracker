<?php

namespace App\Entity;

use App\Repository\PickedBoxRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PickedBoxRepository::class)
 */
class PickedBox
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
    private $boxId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoxId(): ?string
    {
        return $this->boxId;
    }

    public function setBoxId(string $boxId): self
    {
        $this->boxId = $boxId;

        return $this;
    }
}
