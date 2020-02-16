<?php

namespace Labstag\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Labstag\Entity\Formbuilder;
use Labstag\Lib\ServiceEntityRepositoryLib;

/**
 * @method Formbuilder|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formbuilder|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formbuilder[]    findAll()
 * @method Formbuilder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormbuilderRepository extends ServiceEntityRepositoryLib
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formbuilder::class);
    }

    // /**
    //  * @return Formbuilder[] Returns an array of Formbuilder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Formbuilder
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}