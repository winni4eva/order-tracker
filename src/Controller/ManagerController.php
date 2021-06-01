<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\LogService;
use App\Service\OrderService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_MANAGER")
 */
class ManagerController extends BaseController
{

    protected $orderService;

    protected $logService;

    protected $paginator;

    const LIMIT_PER_PAGE = 5;

    const MANAGER_STATES = 'ORDER_RECEIVED,ORDER_CANCELED,ORDER_PROCESSING,ORDER_READY_TO_SHIP,ORDER_SHIPPED';

    public function __construct(
        OrderService $orderService,
        LogService $logService,
        PaginatorInterface $paginator
    )
    {
        $this->orderService = $orderService;
        $this->logService = $logService;
        $this->paginator = $paginator;
    }

    public function index(Request $request): Response
    {
        $orders = $this->orderService->findByState(self::MANAGER_STATES);
        $pagination = $this->paginator->paginate(
            $orders,
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE
        );
        $logs = $this->logService->findAll();
        $paginationLogs = $this->paginator->paginate(
            $logs,
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE
        );

        return $this->render(
            'admin/managers/index.html.twig', 
            compact('pagination', 'paginationLogs')
        );
    }

    public function getOrder(int $id, Request $request): Response
    {
        $orders = $this->orderService->findByState(self::MANAGER_STATES);
        $pagination = $this->paginator->paginate(
            $orders,
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE
        );
        $logs = $this->logService->findAll();
        $paginationLogs = $this->paginator->paginate(
            $logs,
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE
        );
        $order = $this->orderService->find($id);

        return $this->render(
            'admin/managers/index.html.twig', 
            compact('pagination','order', 'paginationLogs')
        );
    }
}
