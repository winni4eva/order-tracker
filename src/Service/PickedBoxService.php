<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\PickedBox;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class PickedBoxService
{

    private $entityManager;

    protected $orderRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        OrderRepository $orderRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
    }

    public function saveBoxId( int $orderId, string $boxId): void
    {
        $user = $this->userRepository->findOneByRoleField('PICKER');
        $order = $this->orderRepository->findOneById($orderId);

        $pickedBox = new PickedBox();
        $pickedBox->setBoxId($boxId);
        $pickedBox->setOrderId($order);
        $pickedBox->setUserId($user);

        $this->entityManager->persist($pickedBox);
        $this->entityManager->flush();
    }

}
