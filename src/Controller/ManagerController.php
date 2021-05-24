<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\LogService;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ManagerController extends AbstractController
{

    protected $orderService;

    protected $logService;

    const MANAGER_STATES = 'ORDER_RECEIVED,ORDER_CANCELED,ORDER_PROCESSING,ORDER_READY_TO_SHIP,ORDER_SHIPPED';

    public function __construct(
        OrderService $orderService,
        LogService $logService
    )
    {
        $this->orderService = $orderService;
        $this->logService = $logService;
    }

    public function index(): Response
    {
        $orders = $this->orderService->findByState(self::MANAGER_STATES);
        $logs = $this->logService->findAll();

        return $this->render(
            'admin/managers/index.html.twig', 
            compact('orders', 'logs')
        );
    }

    public function getOrder(int $id): Response
    {
        $orders = $this->orderService->findByState(self::MANAGER_STATES);
        $logs = $this->logService->findAll();
        $order = $this->orderService->find($id);

        return $this->render(
            'admin/managers/index.html.twig', 
            compact('orders','order', 'logs')
        );
    }
}
