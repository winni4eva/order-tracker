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
        
        $form = $this->createForm(OrderType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
           $orderFormData = $form->getData();
           dump($orderFormData);
           //$orderService->saveOrder($orderFormData);
            unset($form);
            $form = $this->createForm(OrderType::class);
        }
        $orders = $this->getDoctrine()->getRepository(Order::class)->findAll();
        dump($orders);

        return $this->render('home/home.html.twig', [
            'orders' => $orders,
            'form' => $form->createView(),
        ]);
    }

}
