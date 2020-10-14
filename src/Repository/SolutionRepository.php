<?php

namespace App\Repository;

use App\Entity\Solution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use InvalidArgumentException;
use RuntimeException;

/**
 * @method Solution|null find($id, $lockMode = null, $lockVersion = null)
 * @method Solution|null findOneBy(array $criteria, array $orderBy = null)
 * @method Solution[]    findAll()
 * @method Solution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Solution::class);
    }

    /**
     * 
     * @return Solution.id[] Returns an array of id
     * @throws InvalidArgumentException 
     * @throws RuntimeException 
     * @throws ORMException 
     */
    public function getId()
    {
        return $this->createQueryBuilder('p')
            ->select('p.id')
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Solution[] Returns an array of Solution objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Solution
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
