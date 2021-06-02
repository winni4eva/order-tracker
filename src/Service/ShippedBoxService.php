<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\ShippedBox;
use App\Repository\OrderRepository;
use App\Repository\ShippedBoxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class ShippedBoxService
{

    protected $shippedBoxRepository;

    protected $orderRepository;

    private $entityManager;

    private $security;

    public function __construct(
        ShippedBoxRepository $shippedBoxRepository,
        EntityManagerInterface $entityManager,
        OrderRepository $orderRepository,
        Security $security
    )
    {
        $this->shippedBoxRepository = $shippedBoxRepository;
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
        $this->security = $security;
    }

    public function saveShippedBox(int $orderId, array $details): void
    {
        [
            'tracking' => $tracking,
            'courier' => $courier,
            'imgPath' => $imgPath
        ] = $details;
        $user = $this->security->getUser();
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
