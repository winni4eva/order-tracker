<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\AbstractApiController;
use App\Entity\OrderItem;
use App\Entity\OrderShippingDetail;
use App\Form\Type\OrderType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    public function index(Request $request): Response
    {
        $orders = $this->getDoctrine()->getRepository(Order::class)->findAll();

        return $this->json($orders);
    }

    public function create(Request $request): Response
    {
        $data = $request->toArray();
        $items = $data['orderItems'];
        $shippingDetail = $data['orderShippingDetail'];
        
        $order = new Order();
        $order->setTotal($data['total']);
        $order->setDiscount($data['discount']);
        $order->setState($data['state']);

        $entityManager = $this->getDoctrine()->getManager();
        foreach ($items as $item) {
            $orderItem = new OrderItem();
            $orderItem->setName($item['name']);
            $orderItem->setPrice($item['price']);
            $orderItem->setQuantity($item['quantity']);
            $order->addOrderItem($orderItem);
            $entityManager->persist($orderItem);
        }

        $orderShippingDetail = new OrderShippingDetail();
        $orderShippingDetail->setCountry($shippingDetail['country']);
        $orderShippingDetail->setState($shippingDetail['state']);
        $orderShippingDetail->setZip($shippingDetail['zip']);
        $orderShippingDetail->setStreet($shippingDetail['street']);
        $orderShippingDetail->setPhone($shippingDetail['phone']);
        $order->setOrderShippingDetail($orderShippingDetail);

        
        $entityManager->persist($orderShippingDetail);
        $entityManager->persist($order);
        $entityManager->flush();

        return $this->json(['message' => 'Order created successfully'], 201);
    }

    public function cancelOrder(Request $request): Response
    {
        $data = $request->toArray();
        
        return $this->json(['message' => 'Order cancelled successfully']);
    }
}