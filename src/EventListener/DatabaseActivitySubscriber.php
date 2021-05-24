<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Order;
use App\Entity\OrderLog;
use App\Repository\UserRepository;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class DatabaseActivitySubscriber implements EventSubscriber
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            //Events::postRemove,
            Events::postUpdate,
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->logActivity('persist', $args);
    }

    // public function postRemove(LifecycleEventArgs $args): void
    // {
    //     $this->logActivity('remove', $args);
    // }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->logActivity('update', $args);
    }

    private function logActivity(string $action, LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Order) {
            return;
        }

        $entityManager = $args->getObjectManager();
        $this->logOrderMessage($entity, $entityManager);
    }

    private function logOrderMessage(Order $entity, EntityManager $entityManager): void
    {
        $logMessage = '';
        $logState = '';
        $state = $entity->getState();
        $orderId = $entity->getId();

        switch ($state) {
            case 'ORDER_RECEIVED':
                $user = $this->userRepository->findOneByRoleField('CUSTOMER'); //TODO Should be from an authnticated user
                $logState = 'RECEIVED';
                $logMessage = "Order #$orderId has been received by the system";
                break;
            case 'ORDER_PROCESSING':
                $user = $this->userRepository->findOneByRoleField('PICKER'); //TODO Should be from an authnticated user
                $username = $user->getFirstName().' '. $user->getLastName();
                $userId = $user->getId();
                $logState = 'PROCESSING';
                $logMessage = "Order #$orderId has been changed to PROCESSING by $username ($userId";
                break;
            case 'ORDER_READY_TO_SHIP':
                $user = $this->userRepository->findOneByRoleField('PICKER'); //TODO Should be from an authnticated user
                $username = $user->getFirstName().' '. $user->getLastName();
                $userId = $user->getId();
                $logState = 'READY TO SHIP';
                $logMessage = "Order #$orderId has been changed to READY TO SHIP by $username ($userId) with BOX_ID: 1213";
                break;
            case 'ORDER_SHIPPED':
                $user = $this->userRepository->findOneByRoleField('SHIPPER'); //TODO Should be from an authnticated user
                $username = $user->getFirstName().' '. $user->getLastName();
                $userId = $user->getId();
                $logState = 'SHIPPED';
                $logMessage = "Order #$orderId has been changed to SHIPPED by $username ($userId) with AWB: #21321313131 by UPS [View Label]";
                break;
            default:
                $user = $this->userRepository->findOneByRoleField('CUSTOMER'); //TODO Should be from an authnticated user
                $logState = 'UNKNOWN';
                $logMessage = "The $state change by Order #$orderId 's was not processed correctly";
                break;
        }

        $log = new OrderLog();
        $log->setState($logState);
        $log->setMessage($logMessage);
        $log->setUserId($user);
        $log->setOrderId($entity);

        $entityManager->persist($log);
        $entityManager->flush();
    }
}
