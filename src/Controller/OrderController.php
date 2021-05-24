<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    public function index(Request $request): Response
    {
        $orders = $this->getDoctrine()->getRepository(Order::class)->findAll();

        return $this->json(compact('orders'), Response::HTTP_OK);
    }

    public function create(Request $request, OrderService $orderService): Response
    {
        $data = $request->toArray();
        $savedOrder = $orderService->saveOrder($data);

        if (!$savedOrder) {
            return $this->json(
                ['message' => 'Order create failed'], 
                Response::HTTP_BAD_REQUEST
            ); 
        }
        return $this->json(
            ['message' => 'Order created successfully'], 
            Response::HTTP_CREATED
        );
    }

    public function cancelOrder(Request $request): Response
    {
        $data = $request->toArray();

        return $this->json(['message' => 'Order cancelled successfully']);
    }
}