<?php

namespace App\Controller;

use App\Dto\RecipeDto;
use App\Repository\RecipeRepository;
use App\Service\RecipeMapper;
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
            $params = $this->extractFromRequest($request, ['search', 'orderBy', 'limit', 'offset']);
            extract($params);
            return $this->json($recipeRepository->listBy($search ?? '', $orderBy, 0, 0, true, true));
        }
    }

    #[Route('/recipe/get', name: 'app_recipe_get')]
    public function get(Request $request, RecipeMapper $recipeMapper): Response
    {
        $id = $request->get('id');
        return $this->json($recipeMapper->get($id));
    }

    #[Route('/recipe/save', name: 'app_recipe_save')]
    public function save(Request $request, RecipeMapper $recipeMapper)
    {
        $data = json_decode($request->getContent());
        $recipeDto = new RecipeDto($data->recipe);
        $recipeDto->ingredients = $data->ingredients;

        $imgDir = $this->getParameter('images_dir');
        //get image!

        return $this->json($recipeMapper->save($recipeDto));

    }
}
