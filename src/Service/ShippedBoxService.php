<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ShippedBox;
use App\Repository\OrderRepository;
use App\Repository\ShippedBoxRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class ShippedBoxService
{

    protected $shippedBoxRepository;

    protected $userRepository;

    protected $orderRepository;

    private $entityManager;

    public function __construct(
        ShippedBoxRepository $shippedBoxRepository,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        OrderRepository $orderRepository
    )
    {
        $this->shippedBoxRepository = $shippedBoxRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
    }

    public function saveShippedBox(int $orderId, array $details): void
    {
        [
            'tracking' => $tracking,
            'courier' => $courier,
            'imgPath' => $imgPath
        ] = $details;
        $user = $this->userRepository->findOneByRoleField('SHIPPER');
        $order = $this->orderRepository->findOneById($orderId);

        $shippedBox = new ShippedBox();
        $shippedBox->setCourier($courier);
        $shippedBox->setLabelImage($imgPath);
        $shippedBox->setTracking($tracking);
        $shippedBox->setOrderId($order);
        $shippedBox->setUserId($user);

        $this->entityManager->persist($shippedBox);
        $this->entityManager->flush();
    }

}
