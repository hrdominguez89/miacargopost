<?php

namespace App\Repository;

use App\Entity\S10Code;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<S10Code>
 *
 * @method S10Code|null find($id, $lockMode = null, $lockVersion = null)
 * @method S10Code|null findOneBy(array $criteria, array $orderBy = null)
 * @method S10Code[]    findAll()
 * @method S10Code[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class S10CodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, S10Code::class);
    }

    public function countRecordsByServiceCodeAndCountryBeforeOrEqualToId(int $id): int
    {
        $subQueryCountry = $this->createQueryBuilder('psaux1')
            ->select('IDENTITY(psaux1.toCountry)')
            ->where('psaux1.id = :id');

        $subQueryServiceCode = $this->createQueryBuilder('psaux2')
            ->select('psaux2.serviceCode')
            ->where('psaux2.id = :id');

        $qb = $this->createQueryBuilder('ps')
            ->select('COUNT(ps.id) as cantidad')
            ->where('IDENTITY(ps.toCountry) = (' . $subQueryCountry->getDQL() . ')')
            ->andWhere('ps.serviceCode = (' . $subQueryServiceCode->getDQL() . ')')
            ->andWhere('ps.id <= :id')
            ->groupBy('ps.toCountry, ps.serviceCode')
            ->setParameter('id', $id);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    public function findByS10Code($s10Code){
        $qb = $this->createQueryBuilder('s10')
            ->where('s10.barcodeImage = :s10Code')
            ->setParameter('s10Code', '/barcodes/s10/'.$s10Code.'.png');
        return $qb->getQuery()->getOneOrNullResult();
    }

    //    /**
    //     * @return S10Code[] Returns an array of S10Code objects
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

    //    public function findOneBySomeField($value): ?S10Code
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
