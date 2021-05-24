<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ShipperController extends AbstractController
{
    protected $orderService;

    const SHIPPER_STATES = 'ORDER_READY_TO_SHIP';

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(): Response
    {
        $orders = $this->orderService->findByState(self::SHIPPER_STATES);

        return $this->render('admin/shippers/index.html.twig', compact('orders'));
    }

    public function getOrder(int $id): Response
    {
        $orders = $this->orderService->findByState(self::SHIPPER_STATES);
        $order = $this->orderService->find($id);

        return $this->render(
            'admin/shippers/index.html.twig', 
            compact('orders','order')
        );
    }

    public function changeState(int $id, string $state): Response
    {
        $order = $this->orderService->setOrderState($id, $state);
        $orders = $this->orderService->findByState(self::SHIPPER_STATES);

        return $this->render(
            'admin/shippers/index.html.twig', 
            compact('orders','order')
        );
    }
}
