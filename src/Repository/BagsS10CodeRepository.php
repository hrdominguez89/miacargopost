<?php

namespace App\Repository;

use App\Entity\BagsS10Code;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BagsS10Code>
 *
 * @method BagsS10Code|null find($id, $lockMode = null, $lockVersion = null)
 * @method BagsS10Code|null findOneBy(array $criteria, array $orderBy = null)
 * @method BagsS10Code[]    findAll()
 * @method BagsS10Code[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BagsS10CodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BagsS10Code::class);
    }

//    /**
//     * @return BagsS10Code[] Returns an array of BagsS10Code objects
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

//    public function findOneBySomeField($value): ?BagsS10Code
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
