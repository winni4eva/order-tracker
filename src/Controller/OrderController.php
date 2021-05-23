<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\AbstractApiController;
use App\Form\Type\OrderType;

class OrderController extends AbstractApiController
{
    public function index(Request $request): Response
    {
        $orders = $this->getDoctrine()->getRepository(Order::class)->findAll();

        return $this->json($orders);
    }

    public function create(Request $request): Response
    {
        $form = $this->buildForm(OrderType::class);
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !$form->isValid()) {
            // throw exception
            return $this->json(['Error' => 'Failed saving'], 400);
        }
        $order = $form->getData();
        $this->getDoctrine()->getManager()->persist($order);
        $this->getDoctrine()->getManager()->flush();

        return $this->json(['Success' => 'Failed saving'], 201);
    }
}