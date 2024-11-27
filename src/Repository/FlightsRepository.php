<?php

namespace App\Repository;

use App\Entity\Flights;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Flights>
 *
 * @method Flights|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flights|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flights[]    findAll()
 * @method Flights[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlightsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flights::class);
    }

}
