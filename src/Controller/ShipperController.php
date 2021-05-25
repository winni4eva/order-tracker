<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\OrderService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShipperController extends AbstractController
{
    protected $orderService;

    protected $paginator;

    const SHIPPER_STATES = 'ORDER_READY_TO_SHIP';

    const LIMIT_PER_PAGE = 5;

    public function __construct(
        OrderService $orderService,
        PaginatorInterface $paginator
    )
    {
        $this->orderService = $orderService;
        $this->paginator = $paginator;
    }

    public function index(Request $request): Response
    {
        $orders = $this->orderService->findByState(self::SHIPPER_STATES);
        $pagination = $this->paginator->paginate(
            $orders,
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE
        );

        return $this->render(
            'admin/shippers/index.html.twig', 
            compact('pagination')
        );
    }

    public function getOrder(int $id, Request $request): Response
    {
        $orders = $this->orderService->findByState(self::SHIPPER_STATES);
        $pagination = $this->paginator->paginate(
            $orders,
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE
        );
        $order = $this->orderService->find($id);

        return $this->render(
            'admin/shippers/index.html.twig', 
            compact('pagination','order')
        );
    }

    public function changeState(int $id, string $state, Request $request): Response
    {
        $order = $this->orderService->setOrderState($id, $state);
        $orders = $this->orderService->findByState(self::SHIPPER_STATES);
        $pagination = $this->paginator->paginate(
            $orders,
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE
        );

        return $this->render(
            'admin/shippers/index.html.twig', 
            compact('pagination','order')
        );
    }
}
