<?php

namespace App\Repository;

use App\Entity\ReferencePeopleCivility;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReferencePeopleCivility>
 *
 * @method null|ReferencePeopleCivility find($id, $lockMode = null, $lockVersion = null)
 * @method null|ReferencePeopleCivility findOneBy(array $criteria, array $orderBy = null)
 * @method ReferencePeopleCivility[]    findAll()
 * @method ReferencePeopleCivility[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReferencePeopleCivilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReferencePeopleCivility::class);
    }

    public function save(ReferencePeopleCivility $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReferencePeopleCivility $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PeopleCivility[] Returns an array of PeopleCivility objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PeopleCivility
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
