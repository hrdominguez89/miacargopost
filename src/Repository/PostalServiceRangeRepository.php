<?php

namespace App\Repository;

use App\Entity\PostalProduct;
use App\Entity\PostalService;
use App\Entity\PostalServiceRange;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PostalServiceRange>
 *
 * @method PostalServiceRange|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostalServiceRange|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostalServiceRange[]    findAll()
 * @method PostalServiceRange[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostalServiceRangeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostalServiceRange::class);
    }


    public function getPostalServiceRange(): array
    {
        $qb = $this->createQueryBuilder('psr')
            ->select(
                'psr.id AS id',
                'psr.principalCharacter AS principalCharacter',
                'psr.secondCharacterFrom AS secondCharacterFrom',
                'psr.secondCharacterTo AS secondCharacterTo',
                'ps.name AS serviceName',
                'pp.name as productName'
            )
            ->join(PostalService::class, 'ps', 'WITH', 'psr.postalService = ps.id')
            ->join(PostalProduct::class, 'pp', 'WITH', 'ps.postalProduct = pp.id')
            ->orderBy('pp.name', 'ASC')
            ->addOrderBy('ps.name', 'ASC')
            ->addOrderBy('psr.principalCharacter', 'ASC')
            ->addOrderBy('psr.secondCharacterFrom', 'ASC');

        $results = $qb->getQuery()->getResult();

        // Formatear los resultados para el `ChoiceType`
        $postalServiceRange = [];
        foreach ($results as $result) {
            $formattedRange = sprintf(
                '%s - %s (%s%s-%s%s)',
                $result['productName'],
                $result['serviceName'],
                $result['principalCharacter'],
                $result['secondCharacterFrom'],
                $result['principalCharacter'],
                $result['secondCharacterTo']
            );

            $postalServiceRange[$formattedRange] = $result['id'];
        }

        return $postalServiceRange;
    }
}
