<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends BaseController
{
    #[Route('/recipe/list', name: 'app_recipe_list')]
    public function list(RecipeRepository $recipeRepository, Request $request): Response
    {
        $filters = $request->get('filters');
        if ($filters) {
            return $this->json($recipeRepository->findByFilters(json_decode($filters)));
        } else {
            return $this->fetchList($recipeRepository, $request);
        }
    }

    #[Route('/recipe/get', name: 'app_recipe_get')]
    public function get(RecipeRepository $recipeRepository, Request $request): Response
    {
        return $this->json($recipeRepository->find($request->get('id')));
    }
}
