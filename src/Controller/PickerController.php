<?php

namespace App\Controller;

use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PickerController extends AbstractController
{
    public function index(OrderService $orderService): Response
    {
        $orders = $orderService->findAll();

        return $this->render('admin/pickers/index.html.twig', compact('orders'));
    }

    public function getOrder(int $id, OrderService $orderService): Response
    {
        $orders = $orderService->findAll();
        $order = $orderService->find($id);

        return $this->render(
            'admin/pickers/index.html.twig', 
            compact('orders','order')
        );
    }
}
