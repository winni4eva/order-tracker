<?php

namespace App\Entity;

use App\Repository\OrderIssueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderIssueRepository::class)
 */
class OrderIssue
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $issue;

    /**
     * @ORM\Column(type="datetime",options={"default": "CURRENT_TIMESTAMP"}, nullable=true)
     */
    private $create_at;

    /**
     * @ORM\Column(type="datetime",options={"default": "CURRENT_TIMESTAMP"}, nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="orderIssues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $order_id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="orderIssues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIssue(): ?string
    {
        return $this->issue;
    }

    public function setIssue(string $issue): self
    {
        $this->issue = $issue;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeInterface $create_at): self
    {
        $this->create_at = $create_at;

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

    public function getOrderId(): ?Order
    {
        return $this->order_id;
    }

    public function setOrderId(?Order $order_id): self
    {
        $this->order_id = $order_id;

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

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }
}
