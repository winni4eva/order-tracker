<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\OrderService;

class OrderController extends BaseController
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request): Response
    {
        $orders = $this->orderService->findAll();

        return $this->json(compact('orders'), Response::HTTP_OK);
    }

    public function create(Request $request): Response
    {
        $data = $request->toArray();
        $savedOrder = $this->orderService->saveOrder($data);

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
}