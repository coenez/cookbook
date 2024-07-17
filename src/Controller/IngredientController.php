<?php

namespace App\Controller;


use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use App\Repository\RecipeIngredientRepository;
use App\Repository\UnitRepository;
use App\Serializer\RecipeIngredient as RecipeIngredientSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IngredientController extends BaseController
{
    #[Route('/ingredient/list', name: 'app_ingredient_list')]
    public function list(IngredientRepository $ingredientRepository, Request $request): Response
    {
        return $this->fetchList($ingredientRepository, $request);
    }

    #[Route('/ingredient/save', name: 'app_ingredient_save')]
    public function save(IngredientRepository $ingredientRepository, UnitRepository $unitRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $request = $this->convertJsonPayload($request);

        $ingredient = new Ingredient();
        if ($request->get('id')) {
            $ingredient = $ingredientRepository->find($request->get('id'));
        }

        $unit = $unitRepository->find($request->get('unit'));

        $ingredient->setName($request->get('name'));
        $ingredient->setUnit($unit);

        $entityManager->persist($ingredient);
        $entityManager->flush();

        return $this->json($ingredient);
    }

    #[Route('/ingredient/get/{id<\d>}', name: 'app_ingredient_get')]
    public function get(Ingredient $ingredient): Response
    {
        return $this->json($ingredient);
    }

    #[Route('/ingredient/recipe', name: 'app_ingredient_recipe_get')]
    public function getByRecipe(RecipeIngredientRepository $recipeIngredientRepository, RecipeIngredientSerializer $serializer, Request $request): Response
    {
        $data = $recipeIngredientRepository->findIngredientsByRecipeId(
            $request->get('recipeId')
        );

        $result = [];
        foreach($data as $row) {
            $result[] = $serializer->serialize($row);
        }

        return $this->json($result);
    }
}
