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

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pickedBoxes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="pickedBoxes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $order_id;

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

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getOrderId(): ?Order
    {
        return $this->order_id;
    }

    public function setOrderId(?Order $order_id): self
    {
        $this->order_id = $order_id;

        return $this;
    }
}
