<?php

namespace App\Repository;

use App\Entity\StatusDispatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StatusDispatch>
 *
 * @method StatusDispatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatusDispatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatusDispatch[]    findAll()
 * @method StatusDispatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusDispatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatusDispatch::class);
    }

//    /**
//     * @return StatusDispatch[] Returns an array of StatusDispatch objects
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

//    public function findOneBySomeField($value): ?StatusDispatch
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
