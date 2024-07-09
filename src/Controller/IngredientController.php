<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IngredientController extends AbstractController
{
    #[Route('/ingredient/list', name: 'app_ingredient_list')]
    public function list(IngredientRepository $ingredientRepository): Response
    {
        return $this->json($ingredientRepository->findAll());
    }

    #[Route('/ingredient/get/{id<\d>}', name: 'app_ingredient_get')]
    public function get(Ingredient $ingredient): Response
    {
        return $this->json($ingredient);
    }
}
