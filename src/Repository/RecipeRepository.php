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
        bool $images = false,
        bool $labels = false,
    ): array
    {
        $query = $this->getFindBySearchAndSortQuery($search, $orderBy, $limit, $offset);

        $query->innerJoin('t.category', 'c')->addSelect('c');

        if ($images) {
            $query->leftJoin('t.images', 'i')
                ->addSelect('i');
        }
        if ($labels) {
            $query->leftJoin('t.labels', 'l')
                ->addSelect('l');
        }

        return $query->getQuery()->getResult();
    }

    public function findByFilters(object $filters): array
    {
        $query = $this->createQueryBuilder('r');

        $query->innerJoin('r.category', 'c')->addSelect('c');
        $query->leftJoin('r.labels', 'rl')->addSelect('rl');
        $query->innerJoin('r.recipeIngredients', 'ri')->addSelect('ri');
        $query->leftJoin('r.images', 'i')->addSelect('i');

        if (!empty($filters->category)) {
            $query->andWhere('r.category = :category')
                ->setParameter('category', $filters->category->id);
        }

        if (!empty($filters->labels)) {
            $query->andWhere('rl.id IN (:labels)')
                ->setParameter('labels', array_column($filters->labels, 'id'));
        }

        if (!empty($filters->ingredients)) {
            $query->andWhere('ri.ingredient IN (:ingredients)')
                ->setParameter('ingredients', array_column($filters->ingredients, 'id'));
        }
        $query->orderBy('r.created', 'DESC');
        return $query->getQuery()->getResult();
    }

}
