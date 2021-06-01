<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Order;
use App\Entity\OrderLog;
use App\Entity\User;
use App\Repository\OrderLogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class LogService
{

    private $orderLogRepository;

    private $security;

    private $entityManager;

    public function __construct(
        OrderLogRepository $orderLogRepository,
        Security $security,
        EntityManagerInterface $entityManager
    )
    {
        $this->orderLogRepository = $orderLogRepository;
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function findAll()
    {
        return $this->orderLogRepository->all();
    }

    public function logOrder(Order $order): void
    {
        $state = $order->getState();
        $user = $this->security->getUser();
        
        [$logState, $logMessage] = $this->getLogMessage($order, $state, $user);

        $log = new OrderLog();
        $log->setState($logState);
        $log->setMessage($logMessage);
        $log->setUserId($user);
        $log->setOrderId($order);

        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }

    private function getLogMessage(Order $order, string $state, User $user): array 
    {
        $logMessage = '';
        $logState = '';
        $username = $user->getFirstName().' '. $user->getLastName();
        $orderId = $order->getId();
        $userId = $user->getId();

        switch ($state) {
            case 'ORDER_RECEIVED':
                $logState = 'RECEIVED';
                $logMessage = "Order #$orderId has been received by the system";
                break;
            case 'ORDER_PROCESSING':
                $logState = 'PROCESSING';
                $logMessage = "Order #$orderId has been changed to PROCESSING by $username ($userId)";
                break;
            case 'ORDER_READY_TO_SHIP':
                $logState = 'READY TO SHIP';
                $logMessage = "Order #$orderId has been changed to READY TO SHIP by $username ($userId) with BOX_ID: 1213";
                break;
            case 'ORDER_SHIPPED':
                $logState = 'SHIPPED';
                [ $shippedBox ] = $order->getShippedBoxes();
                $wayBill = $shippedBox->getTracking();
                $courier = $shippedBox->getCourier();
                $logMessage = "Order #$orderId has been changed to SHIPPED by $username ($userId) with AWB: #$wayBill by $courier [View Label]";
                break;
            case 'ORDER_CANCELED':
                $logState = 'CANCELED';
                $logMessage = "Order #$orderId has been cancelled by $username ($userId)";
                break; 
            default:
                $logState = 'UNKNOWN';
                $logMessage = "The $state change by Order #$orderId 's was not processed correctly";
                break;
        }

        return [$logState, $logMessage];
    }

}
