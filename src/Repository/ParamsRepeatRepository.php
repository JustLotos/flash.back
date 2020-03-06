<?php

namespace App\Repository;

use App\Entity\ParamsRepeat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ParamsRepeat|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParamsRepeat|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParamsRepeat[]    findAll()
 * @method ParamsRepeat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParamsRepeatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParamsRepeat::class);
    }

    // /**
    //  * @return ParamsRepeat[] Returns an array of ParamsRepeat objects
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
    public function findOneBySomeField($value): ?ParamsRepeat
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
