<?php

namespace App\Repository;

use App\Entity\Bags;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bags>
 *
 * @method Bags|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bags|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bags[]    findAll()
 * @method Bags[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BagsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bags::class);
    }

//    /**
//     * @return Bags[] Returns an array of Bags objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Bags
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
