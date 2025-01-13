<?php

namespace App\Repository;

use App\Entity\Country;
use App\Entity\Offices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offices>
 *
 * @method Offices|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offices|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offices[]    findAll()
 * @method Offices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfficesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offices::class);
    }

    public function findUniqueAirportsByMailClass($category, $mailClass): array
    {
        $qb = $this->createQueryBuilder('o')
            ->select('DISTINCT SUBSTRING(o.impcCode, 3, 3) as airport')
            ->where('o.categoryAInbound = :category')
            ->andWhere('o.mailClassEInbound = :mailClass')
            ->setParameter('category', $category)
            ->setParameter('mailClass', $mailClass)
            ->orderBy('airport', 'ASC');

        $results = $qb->getQuery()->getResult();

        // Convertir los resultados en un array simple para `ChoiceType`
        $airports = [];
        foreach ($results as $result) {
            $airports[$result['airport']] = $result['airport'];
        }

        return $airports;
    }

    public function findUniqueAirportsWithCountryName(string $category): array
    {
        $qb = $this->createQueryBuilder('o')
            ->select('DISTINCT SUBSTRING(o.impcCode, 3, 3) as airport, c.name as countryName')
            ->leftJoin(Country::class, 'c', 'WITH', 'SUBSTRING(o.impcCode, 1, 2) = c.iso2')
            ->where('o.categoryAInbound = :category')
            ->setParameter('category', $category)
            ->orderBy('countryName', 'ASC')
            ->addOrderBy('airport', 'ASC');

        $results = $qb->getQuery()->getResult();

        $airports = [];
        foreach ($results as $result) {
            $airportFormatted = $result['airport'] . ' (' . $result['countryName'] . ')';
            $airports[$airportFormatted] = $result['airport'];
        }

        return $airports;
    }

    public function findUniqueAirports($category): array
    {
        $qb = $this->createQueryBuilder('o')
            ->select('DISTINCT SUBSTRING(o.impcCode, 3, 3) as airport')
            ->where('o.categoryAInbound = :category')
            ->setParameter('category', $category)
            ->orderBy('airport', 'ASC');

        $results = $qb->getQuery()->getResult();

        // Convertir los resultados en un array simple para `ChoiceType`
        $airports = [];
        foreach ($results as $result) {
            $airports[$result['airport']] = $result['airport'];
        }

        return $airports;
    }

    public function getCountriesFromOfficesQueryBuilder($category): array
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o.id as id, o.impcCode as office', 'o.impcCodeFullName as fullName') // Selecciona ambos campos
            ->where('o.categoryAInbound = :category')
            ->andWhere('o.impcCode LIKE :endsWith') // Filtrar los que terminan en "A"
            ->setParameter('category', $category)
            ->setParameter('endsWith', '%A') // Patrón para terminar en "A"
            ->orderBy('office', 'ASC')
            ->addOrderBy('fullName', 'ASC');

        $results = $qb->getQuery()->getResult();

        // Formatear los resultados para `ChoiceType`
        $offices = [];
        foreach ($results as $result) {
            $formattedOffice = $result['office'] . ' (' . $result['fullName'] . ')'; // Formato deseado
            $offices[$formattedOffice] = $result['id']; // Llave es "office (fullName)", valor es solo el código
        }

        return $offices;
    }

    //    public function findOneBySomeField($value): ?Offices
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
