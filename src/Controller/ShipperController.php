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
        $this->processShippingFormData($request);
        //$order = $this->orderService->setOrderState($id, $state);
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

    private function processShippingFormData(Request $request): array
    {
        $orderStatus = $request->get('status');
        $formData = [];
        switch ($orderStatus) {
            case 'issue':
                $condition = $request->get('condition');
                $detials = $request->get('details');
                break;
            case 'ship':
                $courier = $request->get('courier');
                $tracking = $request->get('tracking');
                $uploadedFile = $request->files->get('image');
                $destination = $this->getParameter('kernel.project_dir').'/public/shipping-images';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $imgPath = $uploadedFile->move($destination, $newFilename);
                dd($imgPath);
                break;
            default:
                # code...
                break;
        }
        return [];
    }
}
