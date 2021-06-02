<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\OrderIssue;
use App\Repository\OrderIssueRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class OrderIssueService
{

    protected $orderIssueRepository;

    protected $orderRepository;

    private $entityManager;

    private $security;

    public function __construct(
        OrderIssueRepository $orderIssueRepository,
        EntityManagerInterface $entityManager,
        OrderRepository $orderRepository,
        Security $security
    )
    {
        $this->orderIssueRepository = $orderIssueRepository;
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
        $this->security = $security;
    }

    public function saveOrderIssue(int $orderId, array $issue): void
    {
        [
            'condition' => $condition,
            'details' => $details
        ] = $issue;
        $user = $this->security->getUser();
        $order = $this->orderRepository->findOneById($orderId);
        
        $orderIssue = new OrderIssue();
        $orderIssue->setIssue($details);
        $orderIssue->setState($condition);
        $orderIssue->setOrderId($order);
        $orderIssue->setUserId($user);

        $this->entityManager->persist($orderIssue);
        $this->entityManager->flush();
    }

}
