<?php

namespace App\Repository;

use App\Entity\Artic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Artic>
 *
 * @method Artic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artic[]    findAll()
 * @method Artic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artic::class);
    }

//    /**
//     * @return Artic[] Returns an array of Artic objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Artic
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
