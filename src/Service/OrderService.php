<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\OrderShippingDetail;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderService
{
    private $entityManager;

    private $orderRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        OrderRepository $orderRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
    }

    public function findAll(): array
    {
        return $this->orderRepository->all();
    }

    public function saveOrder(array $data): bool
    {
        $items = $data['orderItems'];
        $shippingDetail = $data['orderShippingDetail'];
        
        $order = new Order();
        $order->setTotal($data['total']);
        $order->setDiscount($data['discount']);
        $order->setState($data['state']);

        foreach ($items as $item) {
            $orderItem = new OrderItem();
            $orderItem->setName($item['name']);
            $orderItem->setPrice($item['price']);
            $orderItem->setQuantity($item['quantity']);
            $order->addOrderItem($orderItem);
            $this->entityManager->persist($orderItem);
        }

        $orderShippingDetail = new OrderShippingDetail();
        $orderShippingDetail->setCountry($shippingDetail['country']);
        $orderShippingDetail->setState($shippingDetail['state']);
        $orderShippingDetail->setZip($shippingDetail['zip']);
        $orderShippingDetail->setStreet($shippingDetail['street']);
        $orderShippingDetail->setPhone($shippingDetail['phone']);
        $order->setOrderShippingDetail($orderShippingDetail);

        
        $this->entityManager->persist($orderShippingDetail);
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return true;
    }

}
