<?php

namespace App\Repository;

use App\Entity\Citizen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Citizen|null find($id, $lockMode = null, $lockVersion = null)
 * @method Citizen|null findOneBy(array $criteria, array $orderBy = null)
 * @method Citizen[]    findAll()
 * @method Citizen[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CitizenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Citizen::class);
    }

    /*
     * Get 5 Citizen has upcoming birthday
     */
    public function getRecentBirthDay() {
        return $this->createQueryBuilder('c')
            ->orderBy('MONTH(c.dateOfBirth)', 'ASC')
            ->addOrderBy('DATE(c.dateOfBirth)', 'ASC')
            ->setMaxResults(5)
            ->getQuery()->getResult();
    }

    /*
     * Get number of all citizen
     */
    public function countCitizen(): int {
        return $this->createQueryBuilder("c")
            ->select('count(c) as count')
            ->getQuery()
            ->getSingleResult()['count'];
    }

    public function statistic() {
        return $this->createQueryBuilder('c')
                    ->select("YEAR(CURRENT_DATE()) - YEAR(c.dateOfBirth) as age, count(YEAR(CURRENT_DATE()) - YEAR(c.dateOfBirth)) as count")
                    ->groupBy('age')
                    ->getQuery()->getResult();
    }
}
