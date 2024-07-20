<?php

namespace App\Service;

use App\Dto\RecipeDto;
use App\Entity\Recipe;
use App\Entity\RecipeIngredient;
use App\Repository\CategoryRepository;
use App\Repository\IngredientRepository;
use App\Repository\LabelRepository;
use App\Repository\RecipeIngredientRepository;
use App\Repository\RecipeRepository;
use App\Serializer\RecipeIngredient as RecipeIngredientSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Mapper class that handles the saving and fetching of the several entities that together form the complete recipe.
 */
class RecipeMapper {

    public function __construct(
        private readonly RecipeRepository $recipeRepository,
        private readonly LabelRepository $labelRepository,
        private readonly CategoryRepository $categoryRepository,
        private readonly RecipeIngredientRepository $recipeIngredientRepository,
        private readonly IngredientRepository $ingredientRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly RecipeIngredientSerializer $recipeIngredientSerializer
    ) {
    }

    public function get($id): array {
        $recipe = $this->recipeRepository->find($id);

        if (!$recipe) {
            throw new NotFoundHttpException("Recipe with id [$id] not found");
        }

        $ingredients = $this->recipeIngredientRepository->findIngredientsByRecipeId($id);
        $serializedIngredients = [];
        foreach($ingredients as $row) {
            $serializedIngredients[] = $this->recipeIngredientSerializer->serialize($row);
        }

        return ['recipe' => $recipe, 'ingredients' => $serializedIngredients];
    }

    public function save(RecipeDto $recipeDto) {

        if ($recipeDto->id) {
            $recipe = $this->recipeRepository->find($recipeDto->id);
            if (!$recipe) {
                throw new \Exception("Recipe with id [{$recipeDto->id}] was not found.");
            }
            //if not yours, then error

        } else {
            $recipe = new Recipe();
            $recipe->setCreated(new \DateTime());
        }

        if (!$recipeDto->ingredients) {
            throw new NotAcceptableHttpException('Cannot save this recipe. A recipe requires ingredients');
        }

        //validate existing recipes by name
        if ($this->recipeRepository->findBySlug($recipeDto->name)) {
            throw new \Exception("Recipe with name [{$recipeDto->name}] or alike, already exists.");
        }

        //basics
        $recipe->setName($recipeDto->name);
        $recipe->setDuration($recipeDto->duration);
        $recipe->setPortions($recipeDto->portions);
        $recipe->setPreparation($recipeDto->preparation);

        //category
        if ($recipeDto->category) {
            $category = $this->categoryRepository->find($recipeDto->category->id);
            $recipe->setCategory($category);
        }

        //labels
        if ($recipeDto->labels) {
            foreach($recipeDto->labels as $label) {
                $foundLabel = $this->labelRepository->find($label->id);
                $recipe->addLabel($foundLabel);
            }
        }

        $this->entityManager->persist($recipe);
        $this->entityManager->flush();

        //ingredients
        foreach($recipeDto->ingredients as $row) {
            $ingredient = $this->ingredientRepository->find($row->id);
            $recipeIngredient = new RecipeIngredient();
            $recipeIngredient
                ->setRecipe($recipe)
                ->setIngredient($ingredient)
                ->setAmount($row->amount ?? 1);

            $this->entityManager->persist($recipeIngredient);
        }
        $this->entityManager->flush();

        return $this->get($recipe->getId());
    }
}