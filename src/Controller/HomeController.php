<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{

    public function index(Request $request, OrderService $orderService)
    {
        $orders = $this->getDoctrine()->getRepository(Order::class)->findAll();
        $form = $this->createForm(OrderType::class);
        $form->handleRequest($request);
        dump($orders);
        dump($orderService->saveOrder());
        if ($form->isSubmitted() && $form->isValid()) {
           $orderFormData = $form->getData();
           dump($orderFormData);
           // do something interesting here
        }

        return $this->render('home/home.html.twig', [
            'orders' => $orders,
            'form' => $form->createView(),
        ]);
    }

}
