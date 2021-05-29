<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\PickedBoxType;
use App\Service\OrderService;
use App\Service\PickedBoxService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class PickerController extends AbstractController
{

    protected $orderService;

    protected $pickedBoxService;

    protected $paginator;

    const PICKER_STATES = 'ORDER_RECEIVED,ORDER_PROCESSING';

    const LIMIT_PER_PAGE = 5;


    public function __construct(
        OrderService $orderService,
        PaginatorInterface $paginator,
        PickedBoxService $pickedBoxService
    )
    {
        $this->orderService = $orderService;
        $this->paginator = $paginator;
        $this->pickedBoxService = $pickedBoxService;
    }
    public function index(Request $request): Response
    {
        $orders = $this->orderService->findByState(self::PICKER_STATES);
        $form = $this->createForm(PickedBoxType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $pickedFormData = $form->getData();
            //$this->orderService->saveOrder($this->processFormData($orderFormData));
            dump($pickedFormData);
            unset($form);
            $form = $this->createForm(PickedBoxType::class);
        }

        $pagination = $this->paginator->paginate(
            $orders,
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE
        );

        return $this->render(
            'admin/pickers/index.html.twig', 
            [
                'pagination' => $pagination, 
                'form' => $form->createView()
            ]
        );
    }

    public function getOrder(int $id, Request $request): Response
    {
        $orders = $this->orderService->findByState(self::PICKER_STATES);
        $pagination = $this->paginator->paginate(
            $orders,
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE
        );
        $order = $this->orderService->find($id);

        return $this->render(
            'admin/pickers/index.html.twig', 
            compact('pagination','order')
        );
    }

    public function changeState(int $id, string $state, Request $request): Response
    {
        $order = $this->orderService->setOrderState($id, $state);
        $pickerBoxId = $request->get('boxId');
        if ($request->get('boxId')) {
            $this->pickedBoxService->saveBoxId($id, $pickerBoxId);
        }
        $orders = $this->orderService->findByState(self::PICKER_STATES);
        $pagination = $this->paginator->paginate(
            $orders,
            $request->query->getInt('page', 1),
            self::LIMIT_PER_PAGE
        );

        return $this->render(
            'admin/pickers/index.html.twig', 
            compact('pagination','order')
        );
    }
}
