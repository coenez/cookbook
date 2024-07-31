<?php

namespace App\Controller;

use App\Dto\RecipeDto;
use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use App\Service\RecipeMapper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class RecipeController extends BaseController
{
    #[Route('/recipe/list', name: 'app_recipe_list')]
    public function list(RecipeRepository $recipeRepository, Request $request): Response
    {
        $filters = $request->get('filters');
        $params = $this->extractFromRequest($request, ['search', 'orderBy', 'limit', 'offset']);
        extract($params);

        if ($filters) {
            return $this->json($recipeRepository->findByFilters(json_decode($filters), $limit, $offset));
        } else {
            return $this->json($recipeRepository->listBy($search ?? '', $orderBy, $limit, $offset));
        }
    }

    #[Route('/recipe/get', name: 'app_recipe_get')]
    public function get(Request $request, RecipeRepository $recipeRepository): Response
    {
        $id = $request->get('id');

        return $this->json($recipeRepository->get($id));
    }

    #[Route('/recipe/save', name: 'app_recipe_save')]
    public function save(Request $request, RecipeMapper $recipeMapper, RecipeRepository $recipeRepository)
    {
        $files = $request->files->all()['files'] ?? [];
        $dir = $this->getParameter('images_dir');
        $path = $this->getParameter('images_path');

        $recipe = json_decode($request->getPayload()->get('recipe'));

        if ($recipe->id) {
            $existing = $recipeRepository->get($recipe->id);
            if (($existing->getUser()->getId() !== $this->getUser()->getId()) && !$this->isGranted('ROLE_ADMIN')) {
                throw $this->createAccessDeniedException('You are not allowed to edit this recipe');
            }
        }

        //process images and prepare image structure
        foreach($files as $file) {
            $info = pathinfo($file->getClientOriginalName());
            $safeFileName = md5($info['filename']);
            $newFileName = $safeFileName . '-' . uniqid() . '.' . $info['extension'];

            $file->move($dir, $newFileName);
            $recipe->images[] = (object)['id'=>null, 'name' => $info['filename'], 'path' => $path.'/'.$newFileName];
        }

        $recipe->user = $this->getUser();
        $recipeDto = new RecipeDto($recipe);

        return $this->json($recipeMapper->save($recipeDto));
    }
}
