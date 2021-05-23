<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
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
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\Column(type="datetime",options={"default": "CURRENT_TIMESTAMP"}, nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime",options={"default": "CURRENT_TIMESTAMP"}, nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=PickedBox::class, mappedBy="user_id")
     */
    private $pickedBoxes;

    /**
     * @ORM\OneToMany(targetEntity=OrderIssue::class, mappedBy="user_id")
     */
    private $orderIssues;

    /**
     * @ORM\OneToMany(targetEntity=OrderLog::class, mappedBy="user_id")
     */
    private $orderLogs;

    /**
     * @ORM\OneToMany(targetEntity=ShippedBox::class, mappedBy="user_id")
     */
    private $shippedBoxes;

    public function __construct()
    {
        $this->pickedBoxes = new ArrayCollection();
        $this->orderIssues = new ArrayCollection();
        $this->orderLogs = new ArrayCollection();
        $this->shippedBoxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

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

    /**
     * @return Collection|PickedBox[]
     */
    public function getPickedBoxes(): Collection
    {
        return $this->pickedBoxes;
    }

    public function addPickedBox(PickedBox $pickedBox): self
    {
        if (!$this->pickedBoxes->contains($pickedBox)) {
            $this->pickedBoxes[] = $pickedBox;
            $pickedBox->setUserId($this);
        }

        return $this;
    }

    public function removePickedBox(PickedBox $pickedBox): self
    {
        if ($this->pickedBoxes->removeElement($pickedBox)) {
            // set the owning side to null (unless already changed)
            if ($pickedBox->getUserId() === $this) {
                $pickedBox->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OrderIssue[]
     */
    public function getOrderIssues(): Collection
    {
        return $this->orderIssues;
    }

    public function addOrderIssue(OrderIssue $orderIssue): self
    {
        if (!$this->orderIssues->contains($orderIssue)) {
            $this->orderIssues[] = $orderIssue;
            $orderIssue->setUserId($this);
        }

        return $this;
    }

    public function removeOrderIssue(OrderIssue $orderIssue): self
    {
        if ($this->orderIssues->removeElement($orderIssue)) {
            // set the owning side to null (unless already changed)
            if ($orderIssue->getUserId() === $this) {
                $orderIssue->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|OrderLog[]
     */
    public function getOrderLogs(): Collection
    {
        return $this->orderLogs;
    }

    public function addOrderLog(OrderLog $orderLog): self
    {
        if (!$this->orderLogs->contains($orderLog)) {
            $this->orderLogs[] = $orderLog;
            $orderLog->setUserId($this);
        }

        return $this;
    }

    public function removeOrderLog(OrderLog $orderLog): self
    {
        if ($this->orderLogs->removeElement($orderLog)) {
            // set the owning side to null (unless already changed)
            if ($orderLog->getUserId() === $this) {
                $orderLog->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ShippedBox[]
     */
    public function getShippedBoxes(): Collection
    {
        return $this->shippedBoxes;
    }

    public function addShippedBox(ShippedBox $shippedBox): self
    {
        if (!$this->shippedBoxes->contains($shippedBox)) {
            $this->shippedBoxes[] = $shippedBox;
            $shippedBox->setUserId($this);
        }

        return $this;
    }

    public function removeShippedBox(ShippedBox $shippedBox): self
    {
        if ($this->shippedBoxes->removeElement($shippedBox)) {
            // set the owning side to null (unless already changed)
            if ($shippedBox->getUserId() === $this) {
                $shippedBox->setUserId(null);
            }
        }

        return $this;
    }
}
