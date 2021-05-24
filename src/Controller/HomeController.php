<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Service\OrderService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    const LIMIT_PER_PAGE = 5;

    public function index(Request $request, OrderService $orderService, PaginatorInterface $paginator): Response
    {
        
        $form = $this->createForm(OrderType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $orderFormData = $form->getData();
            $orderService->saveOrder($this->processFormData($orderFormData));
            unset($form);
            $form = $this->createForm(OrderType::class);
        }
        $orders = $orderService->findAll();
        $pagination = $paginator->paginate(
            $orders,
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE
        );

        return $this->render('home/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    private function processFormData(array $orderFormData): array
    {
        $orderFormData['orderItems'][] = [
            'name' => $orderFormData['itemName'],
            'price' => (int)($orderFormData['itemPrice'] * 100),
            'quantity' => (int)$orderFormData['itemQuantity']
        ];
        $orderFormData['orderShippingDetail'] = [
            'country' => $orderFormData['country'],
            'state' => $orderFormData['state'],
            'zip' => $orderFormData['zip'],
            'street' => $orderFormData['street'],
            'phone' => $orderFormData['phone'],
        ];
        $orderFormData['state'] = 'ORDER_RECEIVED';
        $orderFormData['discount'] = '0';
        $orderFormData['total'] = (int)($orderFormData['itemPrice'] * 100);

        return $orderFormData;
    }

}
