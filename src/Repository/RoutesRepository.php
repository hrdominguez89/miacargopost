<?php

namespace App\Repository;

use App\Entity\Routes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Routes>
 *
 * @method Routes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Routes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Routes[]    findAll()
 * @method Routes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoutesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Routes::class);
    }

    public function findByCriteria($originOffice, $destinationOffice, $postalServiceRange)
    {
        $qb = $this->createQueryBuilder('r')
            ->join('r.routeServiceRanges', 'rsr') // Relación con RouteServiceRange
            ->join('rsr.serviceRange', 'psr')    // Relación con PostalServiceRange
            ->where('r.originOffice = :originOffice')
            ->andWhere('r.destinationOffice = :destinationOffice')
            ->andWhere('psr.id = :postalServiceRange')
            ->setParameter('originOffice', $originOffice)
            ->setParameter('destinationOffice', $destinationOffice)
            ->setParameter('postalServiceRange', $postalServiceRange);

        return $qb->getQuery()->getResult();
    }

    public function findByCriteriaDate($originOffice, $destinationOffice, $postalServiceRange)
    {
        $today = new \DateTime();

        $qb = $this->createQueryBuilder('r')
            ->join('r.routeServiceRanges', 'rsr') // Relación con RouteServiceRange
            ->join('rsr.serviceRange', 'psr')    // Relación con PostalServiceRange
            ->where('r.originOffice = :originOffice')
            ->andWhere('r.destinationOffice = :destinationOffice')
            ->andWhere('psr.id = :postalServiceRange')
            ->andWhere('r.effectiveFrom <= :today')
            ->andWhere('r.validUntil >= :today')
            ->setParameter('originOffice', $originOffice)
            ->setParameter('destinationOffice', $destinationOffice)
            ->setParameter('postalServiceRange', $postalServiceRange)
            ->setParameter('today', $today->format('Y-m-d'))
            ->orderBy('r.validUntil','DESC')
            ->setMaxResults(1); //esto limita el resultado a 1.

        return $qb->getQuery()->getOneOrNullResult();
    }
}
