<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipe/list', name: 'app_recipe_list')]
    public function list(RecipeRepository $recipeRepository): Response
    {
        return $this->json($recipeRepository->findAll());
    }

    #[Route('/recipe/get/{id<\d>}', name: 'app_recipe_get')]
    public function get(Recipe $recipe): Response
    {
        return $this->json($recipe);
    }
}
