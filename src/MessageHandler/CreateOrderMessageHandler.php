<?php

namespace App\MessageHandler;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\OrderShippingDetail;
use App\Message\CreateOrder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateOrderMessageHandler implements MessageHandlerInterface
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(CreateOrder $message)
    {
        $data = $message->getOrder();
        $items = $data['orderItems'];
        $shippingDetail = $data['orderShippingDetail'];
        
        $order = $this->saveOrder($data);
        $this->saveOrderItems($items, $order);
        $orderShippingDetail = $this->saveOrderShippingDetails($shippingDetail, $order);
        
        $this->entityManager->persist($orderShippingDetail);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }

    private function saveOrder(array $data): Order
    {
        $order = new Order();
        $order->setTotal($data['total']);
        $order->setDiscount($data['discount']);
        $order->setState($data['state']);

        return $order;
    }

    private function saveOrderItems(array $items, Order $order): void
    {
        foreach ($items as $item) {
            $orderItem = new OrderItem();
            $orderItem->setName($item['name']);
            $orderItem->setPrice($item['price']);
            $orderItem->setQuantity($item['quantity']);
            $order->addOrderItem($orderItem);
            $this->entityManager->persist($orderItem);
        }
    }

    private function saveOrderShippingDetails(array $shippingDetail, Order $order): OrderShippingDetail
    {
        $orderShippingDetail = new OrderShippingDetail();
        $orderShippingDetail->setCountry($shippingDetail['country']);
        $orderShippingDetail->setState($shippingDetail['state']);
        $orderShippingDetail->setZip($shippingDetail['zip']);
        $orderShippingDetail->setStreet($shippingDetail['street']);
        $orderShippingDetail->setPhone($shippingDetail['phone']);
        $order->setOrderShippingDetail($orderShippingDetail);

        return $orderShippingDetail;
    }

}
