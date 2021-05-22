<?php

namespace App\Repository;

use App\Entity\PickedBox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PickedBox|null find($id, $lockMode = null, $lockVersion = null)
 * @method PickedBox|null findOneBy(array $criteria, array $orderBy = null)
 * @method PickedBox[]    findAll()
 * @method PickedBox[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PickedBoxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PickedBox::class);
    }

    // /**
    //  * @return PickedBox[] Returns an array of PickedBox objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PickedBox
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
