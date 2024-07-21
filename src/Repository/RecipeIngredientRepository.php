<?php

namespace App\Repository;

use App\Entity\RecipeIngredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeIngredient>
 */
class RecipeIngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeIngredient::class);
    }

    public function findIngredientsByRecipeId(int $recipeId): array
    {
        return $this->createQueryBuilder('ri')
            ->innerJoin('ri.ingredient', 'i')
            ->where('ri.recipe= :recipe')
            ->setParameter('recipe', $recipeId)
            ->getQuery()
            ->getResult();
    }

    public function deleteFromRecipe(int $recipeId)
    {
        $this->createQueryBuilder('ri')
            ->delete()
            ->where('ri.recipe= :recipe')
            ->setParameter('recipe', $recipeId)
            ->getQuery()
            ->execute();
    }
}
