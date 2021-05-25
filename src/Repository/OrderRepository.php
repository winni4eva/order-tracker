<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    // /**
    //  * @return Order[] Returns an array of Order objects
    //  */
    public function findByState(array $states)
    {
        $queryBuilder = $this->createQueryBuilder('o');
        $expr = $queryBuilder->expr();
        $stateNo = 0;

        foreach ($states as $state) {
            $queryBuilder = $queryBuilder
                ->orWhere($expr->eq('o.state', ':val'.$stateNo))
                ->setParameter('val'.$stateNo, $state);
            $stateNo += 1;
        }

        return $queryBuilder->orderBy('o.id', 'DESC')
                    ->getQuery();
    }

    public function findOneById($id): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
    * @return Order[] Returns an array of Order objects
    */
    public function all()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.id', 'DESC')
            ->getQuery();
    }
}
