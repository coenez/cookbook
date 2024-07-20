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

    public function findByFilters(object $filters): array
    {
        $query = $this->createQueryBuilder('r');

        if (!empty($filters->category)) {
            $query->where('r.category = :category')
                ->setParameter('category', $filters->category->id);
        }

        if (!empty($filters->labels)) {
            $query->innerJoin('r.labels', 'rl')
                ->where('rl.id IN (:labels)')
                ->setParameter('labels', array_column($filters->labels, 'id'));
        }

        if (!empty($filters->ingredients)) {
            $query->innerJoin('r.recipeIngredients', 'ri')
                ->where('ri.ingredient IN (:ingredients)')
                ->setParameter('ingredients', array_column($filters->ingredients, 'id'));
        }
        return $query->getQuery()->getResult();
    }

    private function nameToSlug($name) {
        return str_replace(' ','', trim(strtolower($name)));
    }

    public function findBySlug(string $name): ?Recipe
    {
        $query = $this->createQueryBuilder('r');
        $result = $query
            ->where("REPLACE(TRIM(LOWER(r.name)), ' ','') = :name")
            ->setParameter('name', $this->nameToSlug($name))
            ->getQuery()->getResult();

        return count($result) ? $result[0] : null;
    }

}
