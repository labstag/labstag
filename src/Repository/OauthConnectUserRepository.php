<?php

namespace Labstag\Repository;

use Labstag\Entity\OauthConnectUser;
use Labstag\Lib\ServiceEntityRepositoryLib;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method null|OauthConnectUser find($id, $lockMode = null, $lockVersion = null)
 * @method null|OauthConnectUser findOneBy(array $criteria, array $orderBy = null)
 * @method OauthConnectUser[]    findAll()
 * @method OauthConnectUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OauthConnectUserRepository extends ServiceEntityRepositoryLib
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OauthConnectUser::class);
    }

    // /**
    //  * @return OauthConnectUser[] Returns an array of OauthConnectUser objects
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
    public function findOneBySomeField($value): ?OauthConnectUser
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