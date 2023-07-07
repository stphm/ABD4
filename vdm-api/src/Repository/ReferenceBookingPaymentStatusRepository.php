<?php

namespace App\Repository;

use App\Entity\ReferenceBookingPaymentStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReferenceBookingPaymentStatus>
 *
 * @method ReferenceBookingPaymentStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReferenceBookingPaymentStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReferenceBookingPaymentStatus[]    findAll()
 * @method ReferenceBookingPaymentStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferenceBookingPaymentStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReferenceBookingPaymentStatus::class);
    }

    public function save(ReferenceBookingPaymentStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReferenceBookingPaymentStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ReferenceBookingPaymentStatus[] Returns an array of ReferenceBookingPaymentStatus objects
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

//    public function findOneBySomeField($value): ?ReferenceBookingPaymentStatus
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
