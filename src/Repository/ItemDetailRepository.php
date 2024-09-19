<?php

namespace App\Repository;

use App\Entity\ItemDetail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ItemDetail>
 *
 * @method ItemDetail|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemDetail|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemDetail[]    findAll()
 * @method ItemDetail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemDetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemDetail::class);
    }

//    /**
//     * @return ItemDetail[] Returns an array of ItemDetail objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ItemDetail
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
