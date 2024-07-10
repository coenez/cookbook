<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
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

    #[Route('/ingredient/get/{id<\d>}', name: 'app_ingredient_get')]
    public function get(Ingredient $ingredient): Response
    {
        return $this->json($ingredient);
    }
}
