<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 */
class RecipeRepository extends ServiceEntityRepository
{
    use GlobalRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function listBy(
        string $search = '',
        string $orderBy = '',
        int $limit = 0,
        int $offset = 0,
    ): array
    {
        $query = $this->getFindBySearchAndSortQuery($search, $orderBy, $limit, $offset);

        $query->innerJoin('t.category', 'c')->addSelect('c');
        $query->innerJoin('t.user', 'u')->addSelect('u');
        $query->leftJoin('t.images', 'i')->addSelect('i');

        return $query->getQuery()->getResult();
    }

    public function get(int $id): Recipe
    {
        $query = $this->createQueryBuilder('r');
        return $query->innerJoin('r.category', 'c')
            ->addSelect('c')
            ->innerJoin('r.user', 'u')
            ->addSelect('u')
            ->leftJoin('r.images', 'i')
            ->addSelect('i')
            ->leftJoin('r.labels', 'l')
            ->addSelect('l')
            ->innerJoin('r.recipeIngredients', 'ri')
            ->addSelect('ri')
            ->where('r.id = :recipeId')
            ->setParameter('recipeId', $id)
            ->getQuery()
            ->getSingleResult();
    }

    public function findByFilters(object $filters, int $limit =0, int $offset=0): array
    {
        $query = $this->createQueryBuilder('r');
        $query->innerJoin('r.category', 'c')->addSelect('c');
        $query->innerJoin('r.user', 'u')->addSelect('u');
        $query->leftJoin('r.images', 'i')->addSelect('i');

        if (!empty($filters->category)) {
            $query->andWhere('r.category = :category')
                ->setParameter('category', $filters->category->id);
        }

        if (!empty($filters->labels)) {
            $query->leftJoin('r.labels', 'rl')->addSelect('rl');
            $query->andWhere('rl.id IN (:labels)')
                ->setParameter('labels', array_column($filters->labels, 'id'));
        }

        if (!empty($filters->ingredients)) {
            $query->innerJoin('r.recipeIngredients', 'ri')->addSelect('ri');
            $query->andWhere('ri.ingredient IN (:ingredients)')
                ->setParameter('ingredients', array_column($filters->ingredients, 'id'));
        }
        if ($limit) {
            $query->setMaxResults($limit);
        }
        if ($offset) {
            $query->setFirstResult($offset);
        }

        $query->orderBy('r.created', 'DESC');
        return $query->getQuery()->getResult();
    }

}
