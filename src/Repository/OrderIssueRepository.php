<?php

namespace App\Repository;

use App\Entity\OrderIssue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderIssue|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderIssue|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderIssue[]    findAll()
 * @method OrderIssue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderIssueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderIssue::class);
    }

    // /**
    //  * @return OrderIssue[] Returns an array of OrderIssue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderIssue
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
