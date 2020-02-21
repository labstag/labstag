<?php

namespace Labstag\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Labstag\Entity\User;
use Labstag\Lib\ServiceEntityRepositoryLib;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepositoryLib
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @return User|void
     */
    public function loginToken(?string $token)
    {
        if (is_null($token)) {
            return;
        }

        $builder = $this->createQueryBuilder('u');
        $builder->where(
            'u.enable = :enable AND u.apiKey = :apiKey'
        );
        $builder->setParameters(
            [
                'enable' => true,
                'apiKey' => $token,
            ]
        );

        return $builder->getQuery()->getOneOrNullResult();
    }

    /**
     * @return User|void
     */
    public function login(?string $login)
    {
        if (is_null($login)) {
            return;
        }

        $builder = $this->createQueryBuilder('u');
        $builder->where(
            'u.username = :username OR u.email = :email'
        );
        $builder->setParameters(
            [
                'username' => $login,
                'email'    => $login,
            ]
        );

        return $builder->getQuery()->getOneOrNullResult();
    }

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}