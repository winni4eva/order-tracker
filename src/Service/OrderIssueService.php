<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\OrderIssue;
use App\Repository\OrderIssueRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class OrderIssueService
{

    protected $orderIssueRepository;

    protected $userRepository;

    protected $orderRepository;

    private $entityManager;

    public function __construct(
        OrderIssueRepository $orderIssueRepository,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        OrderRepository $orderRepository
    )
    {
        $this->orderIssueRepository = $orderIssueRepository;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
    }

    public function saveOrderIssue(int $orderId, array $issue): void
    {
        [
            'condition' => $condition,
            'details' => $details
        ] = $issue;
        $user = $this->userRepository->findOneByRoleField('SHIPPER');
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
