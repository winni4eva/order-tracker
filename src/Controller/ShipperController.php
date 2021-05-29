<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\OrderIssueService;
use App\Service\OrderService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShipperController extends AbstractController
{
    protected $orderService;

    protected $orderIssueService;

    protected $paginator;

    const SHIPPER_STATES = 'ORDER_READY_TO_SHIP';

    const LIMIT_PER_PAGE = 5;

    public function __construct(
        OrderService $orderService,
        PaginatorInterface $paginator,
        OrderIssueService $orderIssueService
    )
    {
        $this->orderService = $orderService;
        $this->paginator = $paginator;
        $this->orderIssueService = $orderIssueService;
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
        $state = $this->processShippingFormData($id, $request);
        $order = $this->orderService->setOrderState($id, $state);
        $orders = $this->orderService->findByState(self::SHIPPER_STATES);
        $pagination = $this->paginator->paginate(
            $orders,
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE
        );

        return $this->render(
            'admin/shippers/index.html.twig', 
            compact('pagination')
            //compact('pagination','order')
        );
    }

    private function processShippingFormData(int $orderId, Request $request): string
    {
        $orderStatus = $request->get('status');
        $formData = [];
        $state = 'ORDER_SHIPPED';
        switch ($orderStatus) {
            case 'issue':
                $formData['condition'] = $request->get('condition') ?? 'None set';
                $formData['details'] = $request->get('details') ?? 'None set';
                $state = 'ORDER_PROCESSING';
                $this->orderIssueService->saveOrderIssue($orderId, $formData);
                break;
            case 'ship':
                $imgPath = '';
                if ($request->files->get('image')) {
                    $uploadedFile = $request->files->get('image');
                    $destination = $this->getParameter('kernel.project_dir').'/public/shipping-images';
                    $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
                    $uploadedFile->move($destination, $newFilename);
                    $imgPath = "/public/shipping-images/$newFilename";
                }
                $formData['imgPath'] = $imgPath;
                $formData['tracking'] = $request->get('tracking') ?? 'None set';
                $formData['courier'] = $request->get('courier') ?? 'None set';
                break;
            default:
                $formData['imgPath'] = '';
                $formData['tracking'] = 'None set';
                $formData['courier'] = 'None set';
                break;
        }
        return $state;
    }
}
