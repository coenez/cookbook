<?php

namespace App\Repository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

trait GlobalRepositoryTrait {

    public function findBySearchAndSort(string $search = '', string $sort = '', int $limit = 10, int $offset = 0): array
    {
        $alias='t';
        $query = $this->createQueryBuilder($alias);
        if ($limit) {
            $query->setMaxResults($limit);
        }
        if ($offset) {
            $query->setFirstResult($offset);
        }

        if ($search !== '') {
            $query->where($alias . '.name LIKE :search')
                ->setParameter('search', "%$search%");
        }
        if ($sort !== '') {
            $parts = explode('|', $sort);
            $query->orderBy($alias . '.' .$parts[0], $parts[1] ?? 'ASC');
        } else {
            $query->orderBy($alias . '.name', 'ASC');
        }

        return $query->getQuery()->getResult();

    }
}