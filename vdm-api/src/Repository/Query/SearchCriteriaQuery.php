<?php

namespace App\Repository\Query;

use Doctrine\ORM\QueryBuilder;

final class SearchCriteriaQuery
{
    public function __construct(private QueryBuilder $queryBuilder, private array $criteria = [])
    {
    }

    public function getCriteria(): array
    {
        return $this->criteria;
    }

    public function getQuery()
    {
        $this->queryBuilder->select('b, p, t, ps, bs, c, s, r, th')
            ->leftJoin('b.payment', 'p')
            ->leftJoin('p.status', 'ps')
            ->innerJoin('b.status', 'bs')
            ->innerJoin('b.customer', 'c')
            ->innerJoin('b.tickets', 't')
            ->innerJoin('b.session', 's')
            ->innerJoin('s.room', 'r')
            ->innerJoin('r.theme', 'th')
        ;

        if (!empty($this->criteria['status'])) {
            $this->queryBuilder->andWhere('bs.id = :status')
                ->setParameter('status', $this->criteria['status'])
            ;
        }

        if (!empty($this->criteria['customer'])) {
            $this->queryBuilder->andWhere('c.email LIKE :customer')
                ->setParameter('customer', '%'.$this->criteria['customer'].'%')
            ;
        }

        if (!empty($this->criteria['paymentStatus'])) {
            $this->queryBuilder->andWhere('ps.id = :paymentStatus')
                ->setParameter('paymentStatus', $this->criteria['paymentStatus'])
            ;
        }

        if (!empty($this->criteria['dateFrom'])) {
            $this->queryBuilder->andWhere('b.createdAt >= :dateFrom')
                ->setParameter('dateFrom', $this->criteria['dateFrom'])
            ;
        }

        if (!empty($this->criteria['dateTo'])) {
            $this->queryBuilder->andWhere('b.createdAt <= :dateTo')
                ->setParameter('dateTo', $this->criteria['dateTo'])
            ;
        }

        if (!empty($this->criteria['theme'])) {
            $this->queryBuilder->andWhere('t.theme = :theme')
                ->setParameter('theme', $this->criteria['theme'])
            ;
        }

        if (!empty($this->criteria['_query'])) {
            $this->queryBuilder->andWhere('c.email LIKE :query OR c.firstName LIKE :query OR c.lastName LIKE :query')
                ->setParameter('query', '%'.$this->criteria['_query'].'%')
            ;
        }

        return $this->queryBuilder->getQuery();
    }
}
