<?php

namespace App\Repository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

trait GlobalRepositoryTrait {

    protected function getFindBySearchAndSortQuery(string $search = '', string $sort = '', int $limit = 10, int $offset = 0): QueryBuilder
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

        return $query;
    }

    public function findBySearchAndSort(string $search = '', string $sort = '', int $limit = 10, int $offset = 0): array
    {
        return $this->getFindBySearchAndSortQuery($search, $sort, $limit, $offset)->getQuery()->getResult();
    }

    public function nameToSlug($name): string
    {
        return str_replace(' ','', trim(strtolower($name)));
    }

    public function findBySlug(string $name): ?object
    {
        $query = $this->createQueryBuilder('c');
        $result = $query
            ->where("REPLACE(TRIM(LOWER(c.name)), ' ','') = :name")
            ->setParameter('name', $this->nameToSlug($name))
            ->getQuery()->getResult();

        return count($result) ? $result[0] : null;
    }

    public function deleteEntity(int $id)
    {
        $query = $this->createQueryBuilder('c');
        return $query->delete()->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
    }
}