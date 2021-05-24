<?php

namespace App\Controller;

use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PickerController extends AbstractController
{

    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function index(): Response
    {
        $orders = $this->orderService->findAll();

        return $this->render('admin/pickers/index.html.twig', compact('orders'));
    }

    public function getOrder(int $id): Response
    {
        $orders = $this->orderService->findAll();
        $order = $this->orderService->find($id);

        return $this->render(
            'admin/pickers/index.html.twig', 
            compact('orders','order')
        );
    }

    public function changeState(int $id, string $state): Response
    {
        $order = $this->orderService->setOrderState($id, $state);
        $orders = $this->orderService->findAll();

        return $this->render(
            'admin/pickers/index.html.twig', 
            compact('orders','order')
        );
    }
}
