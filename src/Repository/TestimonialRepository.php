<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Testimonial;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder as QueryQueryBuilder;
use Doctrine\ORM\Exception\ORMException as ExceptionORMException;
use Doctrine\ORM\ORMException;
use InvalidArgumentException;
use LogicException;
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
        return $this->findLastTestimoniesQuery()
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    /**
     * retourne la liste des témoignagnes ordonnés
     * @return array 
     * @throws InvalidArgumentException 
     * @throws RuntimeException 
     * @throws LogicException 
     * @throws ExceptionORMException 
     */
    public function getAllTestimonies(): array
    {
        return $this->getAllTestimoniesQuery()
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne la requête construite 
     * @return QueryBuilder 
     * @throws InvalidArgumentException 
     * @throws RuntimeException 
     */
    private function findLastTestimoniesQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.createdAt', 'DESC');
    }

    /**
     * Requête pour récupérer la liste des témoiniages regroupé par solution     *
     * @return QueryBuilder 
     * @throws InvalidArgumentException 
     * @throws RuntimeException 
     */
    private function getAllTestimoniesQuery(): QueryBuilder
    {
        // Construction de la requête
        $query = $this
            ->createQueryBuilder('p')
            ->addSelect('s')                        // Jointure sur la table des solutions
            ->join('p.solution', 's')
            ->orderBy('s.id', 'ASC')                // Ordonné par solution asc
            ->addOrderBy('p.createdAt', 'DESC');    // Ordonné par date de témoignage desc

        return $query;
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
