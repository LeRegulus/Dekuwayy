<?php

namespace App\Repository;

use App\Entity\Anounce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Anounce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Anounce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Anounce[]    findAll()
 * @method Anounce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnounceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Anounce::class);
    }

    // public function search($mots){
    //     $query = $this->createQueryBuilder('a');
    //     $query->where('a.isAvailable = 1');
    //     if($mots =! null){
    //         $query->andWhere('MATCH_AGAINST(a.title, a.desription) AGAINST(:mots boolean)>0')
    //         ->setParameter('mots', $mots);
    //     }
    //     return $query->getQuery()->getResult();
    // }

    public function findDisponible()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isAvailable = 1')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOrder()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findUserAnounce($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.user = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Anounce[] Returns an array of Anounce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Anounce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
