<?php

namespace App\Repository;

use App\Entity\Quotation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Quotation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quotation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quotation[]    findAll()
 * @method Quotation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuotationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quotation::class);
    }

    // /**
    //  * @return Quotation[] Returns an array of Quotation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Quotation
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getLastMonthQuote() {
        return $this->createQueryBuilder('q')
            ->select('count(q.id) as count')
            ->getQuery()
            ->getSingleResult()['count'];
    }

    public function getQuoteData() {
        return $this->createQueryBuilder('q')
            ->select('count(q.id) as count, MONTH(q.createAt) as month, YEAR(q.createAt) as year')
            ->groupBy('month')
            ->addOrderBy("year", "ASC")
            ->addOrderBy("month", "ASC")
            ->getQuery()
            ->getResult();
    }

    public function countQuote(): int {
        return $this->createQueryBuilder('q')
            ->select('count(q) as count')
            ->getQuery()
            ->getSingleResult()['count'];
    }
}
