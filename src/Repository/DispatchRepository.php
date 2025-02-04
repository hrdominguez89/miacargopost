<?php

namespace App\Repository;

use App\Entity\Dispatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dispatch>
 *
 * @method Dispatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dispatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dispatch[]    findAll()
 * @method Dispatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DispatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dispatch::class);
    }

    public function findWithBags(int $id): ?Dispatch
    {
        return $this->createQueryBuilder('d')
            ->leftJoin('d.bags', 'b') // Hacemos JOIN con la relación
            ->addSelect('b') // Cargamos los Bags
            ->where('d.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Dispatch[] Returns an array of Dispatch objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Dispatch
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
