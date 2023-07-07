<?php

namespace App\Repository;

use App\Entity\ReferenceGameRoomTheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReferenceGameRoomTheme>
 *
 * @method ReferenceGameRoomTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReferenceGameRoomTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReferenceGameRoomTheme[]    findAll()
 * @method ReferenceGameRoomTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferenceGameRoomThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReferenceGameRoomTheme::class);
    }

    public function save(ReferenceGameRoomTheme $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReferenceGameRoomTheme $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ReferenceGameRoomTheme[] Returns an array of ReferenceGameRoomTheme objects
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

//    public function findOneBySomeField($value): ?ReferenceGameRoomTheme
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
