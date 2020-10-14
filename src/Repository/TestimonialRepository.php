<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Testimonial;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use InvalidArgumentException;
use RuntimeException;

/**
 * @method Testimonial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Testimonial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Testimonial[]    findAll()
 * @method Testimonial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestimonialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Testimonial::class);
    }

    /**
     * Retourne les 3 derniers témoignages
     * @return Testimonial[] 
     * @throws InvalidArgumentException 
     * @throws RuntimeException 
     * @throws ORMException 
     */
    public function findLastTestimonies(): array
    {
        return $this->findLastQuery()
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne la requête construite 
     * @return QueryBuilder 
     * @throws InvalidArgumentException 
     * @throws RuntimeException 
     */
    private function findLastQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.createdAt', 'DESC');
    }

    // /**
    //  * @return Testimonial[] Returns an array of Testimonial objects
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
    public function findOneBySomeField($value): ?Testimonial
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
