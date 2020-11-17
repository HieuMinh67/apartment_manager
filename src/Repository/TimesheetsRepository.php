<?php

namespace App\Repository;

use App\Entity\Timesheets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Timesheets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Timesheets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Timesheets[]    findAll()
 * @method Timesheets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimesheetsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Timesheets::class);
    }

    // /**
    //  * @return Timesheets[] Returns an array of Timesheets objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Timesheets
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findOneByEmail($email): ?Timesheets
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.userId');
    }
}
