<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Message\CreateOrder;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Messenger\MessageBusInterface;

class OrderService
{
    private $entityManager;

    private $orderRepository;

    private $bus;

    public function __construct(
        EntityManagerInterface $entityManager,
        OrderRepository $orderRepository,
        MessageBusInterface $bus
    )
    {
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
        $this->bus = $bus;
    }

    public function findAll()
    {
        return $this->orderRepository->all();
    }

    public function find(int $orderId): Order
    {
        return $this->orderRepository->findOneById($orderId);
    }

    public function findByState(string $states)
    {
        $statesArray = explode(',', $states);

        return $this->orderRepository->findByState($statesArray);
    }

    public function setOrderState(int $orderId, string $state): Order
    {
        $order = $this->entityManager->getRepository(Order::class)->find($orderId);

        if (!$order) {
            throw new Exception("No order row found for id $orderId", 500);
        }
        
        $order->setState($state);
        $this->entityManager->flush();

        return $order;
    }

    public function saveOrder(array $data): bool
    {
        $this->bus->dispatch(new CreateOrder($data));

        return true;
    }

}
