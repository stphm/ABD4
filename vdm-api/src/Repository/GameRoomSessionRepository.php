<?php

namespace App\Repository;

use App\Entity\GameRoomSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GameRoomSession>
 *
 * @method GameRoomSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameRoomSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameRoomSession[]    findAll()
 * @method GameRoomSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRoomSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameRoomSession::class);
    }

    public function save(GameRoomSession $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GameRoomSession $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return GameRoomSession[] Returns an array of GameRoomSession objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GameRoomSession
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
