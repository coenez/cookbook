<?php

namespace App\Service;

use App\Dto\RecipeDto;
use App\Entity\Image;
use App\Entity\Recipe;
use App\Entity\RecipeIngredient;
use App\Repository\CategoryRepository;
use App\Repository\ImageRepository;
use App\Repository\IngredientRepository;
use App\Repository\LabelRepository;
use App\Repository\RecipeIngredientRepository;
use App\Repository\RecipeRepository;
use App\Repository\UnitRepository;
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
        private readonly UnitRepository $unitRepository,
        private readonly ImageRepository $imageRepository,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function save(RecipeDto $recipeDto) {
        if ($recipeDto->id) {
            $recipe = $this->recipeRepository->get($recipeDto->id);
            if (!$recipe) {
                throw new \Exception("Recipe with id [{$recipeDto->id}] was not found.");
            }

            //if not yours, then error

            //clear out the existing ingredients to prevent duplicates
            $this->recipeIngredientRepository->deleteIngredientsFromRecipe($recipeDto->id);

            //clear out images that are removed
            if (count($recipeDto->images)) {
                $preservedIds = array_filter(array_column($recipeDto->images, 'id'));
                foreach($recipe->getImages() as $image) {
                    if (!in_array($image->getId(), $preservedIds)) {
                        $recipe->removeImage($image);
                    }
                }
                $this->entityManager->persist($recipe);
                $this->entityManager->flush();
            }
        } else {
            //validate existing recipes by name
            if ($this->recipeRepository->findBySlug($recipeDto->name)) {
                throw new \Exception("Recipe with name [{$recipeDto->name}] or alike, already exists.");
            }

            $recipe = new Recipe();
            $recipe->setCreated(new \DateTime());
        }

        if (empty($recipeDto->recipeIngredients)) {
            throw new NotAcceptableHttpException('Cannot save this recipe. A recipe requires ingredients');
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
        if (count($recipeDto->labels)) {
            foreach($recipeDto->labels as $label) {
                $foundLabel = $this->labelRepository->find($label->id);
                $recipe->addLabel($foundLabel);
            }
        }

        //add new images
        foreach($recipeDto->images as $rawImg) {
            if (!isset($rawImg->id) && isset($rawImg->path)) {
                $image = new Image();
                $image->setName($rawImg->name);
                $image->setPath($rawImg->path);
                $recipe->addImage($image);
                $this->entityManager->persist($image);
            }
        }

        $this->entityManager->persist($recipe);
        $this->entityManager->flush();

        //ingredients and their unit
        foreach($recipeDto->recipeIngredients as $row) {
            $ingredient = $this->ingredientRepository->find($row->ingredient->id);
            $recipeIngredient = new RecipeIngredient();
            $recipeIngredient
                ->setRecipe($recipe)
                ->setIngredient($ingredient)
                ->setUnit($this->getUnits()[$row->unit->id])
                ->setAmount($row->amount ?? 1);

            $this->entityManager->persist($recipeIngredient);
        }
        $this->entityManager->flush();

        return $this->recipeRepository->get($recipe->getId());
    }

    private function getUnits(): array
    {
        $units = [];
        foreach($this->unitRepository->findAll() as $unit) {
            $units[$unit->getId()] = $unit;
        }
        return $units;
    }
}