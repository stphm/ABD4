<?php

namespace App\Repository;

use App\Entity\ReferenceBookingTicketPricing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReferenceBookingTicketPricing>
 *
 * @method ReferenceBookingTicketPricing|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReferenceBookingTicketPricing|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReferenceBookingTicketPricing[]    findAll()
 * @method ReferenceBookingTicketPricing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferenceBookingTicketPricingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReferenceBookingTicketPricing::class);
    }

    public function save(ReferenceBookingTicketPricing $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReferenceBookingTicketPricing $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ReferenceBookingTicketPricing[] Returns an array of ReferenceBookingTicketPricing objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReferenceBookingTicketPricing
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
