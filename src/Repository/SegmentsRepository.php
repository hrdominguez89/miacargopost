<?php

namespace App\Repository;

use App\Entity\Segments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Segments>
 *
 * @method Segments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Segments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Segments[]    findAll()
 * @method Segments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SegmentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Segments::class);
    }

//    /**
//     * @return Segments[] Returns an array of Segments objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Segments
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
