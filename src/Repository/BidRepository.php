<?php

namespace App\Repository;

use App\Entity\Bid;
use App\Entity\Buyer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bid>
 *
 * @method Bid|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bid|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bid[]    findAll()
 * @method Bid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BidRepository extends ServiceEntityRepository implements BidRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bid::class);
    }

    public function getBidsByBuyer(): array
    {
        $queryBuilder = $this->createQueryBuilder('b')
            ->select('IDENTITY(b.buyer) as buyerId', 'b.amount')
            ->leftJoin('b.buyer', 'buyer')
            ->getQuery();

        $results = $queryBuilder->getResult();

        $bids = [];
        foreach ($results as $result) {
            $buyerId = $result['buyerId'];
            $amount = $result['amount'];

            $buyerName = $this->getEntityManager()
                ->getRepository(Buyer::class)
                ->find($buyerId)
                ->getName();

            if (!isset($bids[$buyerName])) {
                $bids[$buyerName] = [];
            }

            $bids[$buyerName][] = $amount;
        }

        return $bids;
    }
}
