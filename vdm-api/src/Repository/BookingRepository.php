<?php

namespace App\Repository;

use App\Entity\Booking;
use App\Entity\ReferenceBookingStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 *
 * @method null|Booking find($id, $lockMode = null, $lockVersion = null)
 * @method null|Booking findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function save(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function countDailyBookings(): int
    {
        $qb = $this->createQueryBuilder('b');
        $qb->select('COUNT(b.id)')
            ->innerJoin('b.status', 's')
            ->where('s.label = :status')
            ->andWhere('b.createdAt >= :start_date')
            ->andWhere('b.createdAt <= :end_date')
            ->setParameter('start_date', new \DateTime('today'))
            ->setParameter('end_date', new \DateTime('tomorrow'))
            ->setParameter('status', ReferenceBookingStatus::STATUS_VALIDATED)
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }
}
