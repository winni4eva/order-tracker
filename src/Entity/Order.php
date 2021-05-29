<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $total;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $discount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\Column(name="created_at",type="datetime",options={"default": "CURRENT_TIMESTAMP"}, nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(name="updated_at",type="datetime",options={"default": "CURRENT_TIMESTAMP"}, nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity=OrderItem::class, mappedBy="order_id")
     */
    private $orderItems;

    /**
     * @ORM\OneToOne(targetEntity=OrderShippingDetail::class, mappedBy="order_id", cascade={"persist", "remove"})
     */
    private $orderShippingDetail;

    /**
     * @ORM\OneToMany(targetEntity=PickedBox::class, mappedBy="order_id")
     */
    private $pickedBoxes;

    /**
     * @ORM\OneToMany(targetEntity=OrderIssue::class, mappedBy="order_id")
     */
    private $orderIssues;

    // /**
    //  * @ORM\OneToMany(targetEntity=OrderLog::class, mappedBy="order_id")
    //  */
    // private $orderLogs;

    // /**
    //  * @ORM\OneToMany(targetEntity=ShippedBox::class, mappedBy="order_id")
    //  */
    // private $shippedBoxes;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
        $this->pickedBoxes = new ArrayCollection();
        $this->orderIssues = new ArrayCollection();
        //$this->orderLogs = new ArrayCollection();
        //$this->shippedBoxes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(?string $discount): self
    {
        $this->discount = $discount;

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
     * @return Collection|OrderItem[]
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems[] = $orderItem;
            $orderItem->setOrderId($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrderId() === $this) {
                $orderItem->setOrderId(null);
            }
        }

        return $this;
    }

    public function getOrderShippingDetail(): ?OrderShippingDetail
    {
        return $this->orderShippingDetail;
    }

    public function setOrderShippingDetail(OrderShippingDetail $orderShippingDetail): self
    {
        // set the owning side of the relation if necessary
        if ($orderShippingDetail->getOrderId() !== $this) {
            $orderShippingDetail->setOrderId($this);
        }

        $this->orderShippingDetail = $orderShippingDetail;

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
            $pickedBox->setOrderId($this);
        }

        return $this;
    }

    public function removePickedBox(PickedBox $pickedBox): self
    {
        if ($this->pickedBoxes->removeElement($pickedBox)) {
            // set the owning side to null (unless already changed)
            if ($pickedBox->getOrderId() === $this) {
                $pickedBox->setOrderId(null);
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
            $orderIssue->setOrderId($this);
        }

        return $this;
    }

    public function removeOrderIssue(OrderIssue $orderIssue): self
    {
        if ($this->orderIssues->removeElement($orderIssue)) {
            // set the owning side to null (unless already changed)
            if ($orderIssue->getOrderId() === $this) {
                $orderIssue->setOrderId(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection|OrderLog[]
    //  */
    // public function getOrderLogs(): Collection
    // {
    //     return $this->orderLogs;
    // }

    // public function addOrderLog(OrderLog $orderLog): self
    // {
    //     if (!$this->orderLogs->contains($orderLog)) {
    //         $this->orderLogs[] = $orderLog;
    //         $orderLog->setOrderId($this);
    //     }

    //     return $this;
    // }

    // public function removeOrderLog(OrderLog $orderLog): self
    // {
    //     if ($this->orderLogs->removeElement($orderLog)) {
    //         // set the owning side to null (unless already changed)
    //         if ($orderLog->getOrderId() === $this) {
    //             $orderLog->setOrderId(null);
    //         }
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection|ShippedBox[]
    //  */
    // public function getShippedBoxes(): Collection
    // {
    //     return $this->shippedBoxes;
    // }

    // public function addShippedBox(ShippedBox $shippedBox): self
    // {
    //     if (!$this->shippedBoxes->contains($shippedBox)) {
    //         $this->shippedBoxes[] = $shippedBox;
    //         $shippedBox->setOrderId($this);
    //     }

    //     return $this;
    // }

    // public function removeShippedBox(ShippedBox $shippedBox): self
    // {
    //     if ($this->shippedBoxes->removeElement($shippedBox)) {
    //         // set the owning side to null (unless already changed)
    //         if ($shippedBox->getOrderId() === $this) {
    //             $shippedBox->setOrderId(null);
    //         }
    //     }

    //     return $this;
    // }
}
