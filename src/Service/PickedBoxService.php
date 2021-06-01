<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\PickedBox;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class PickedBoxService
{

    private $entityManager;

    private $security;

    protected $orderRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        OrderRepository $orderRepository,
        Security $security
    )
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->security = $security;
    }

    public function saveBoxId( int $orderId, string $boxId): void
    {
        $user = $user = $this->security->getUser();
        $order = $this->orderRepository->findOneById($orderId);

        $pickedBox = new PickedBox();
        $pickedBox->setBoxId($boxId);
        $pickedBox->setOrderId($order);
        $pickedBox->setUserId($user);

        $this->entityManager->persist($pickedBox);
        $this->entityManager->flush();
    }

}
