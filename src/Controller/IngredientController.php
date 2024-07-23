<?php

namespace App\Controller;


use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
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
    public function save(IngredientRepository $ingredientRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $request = $this->convertJsonPayload($request);

        $ingredient = new Ingredient();
        if ($request->get('id')) {
            $ingredient = $ingredientRepository->find($request->get('id'));
        }

        //check by slug
        $name = $request->get('name');
        if ($ingredientRepository->findBySlug($name)) {
            throw new \Exception("Ingredient with name [$name] or alike, already exists.");
        }

        $ingredient->setName($name);

        $entityManager->persist($ingredient);
        $entityManager->flush();

        return $this->json($ingredient);
    }

    #[Route('/ingredient/get/{id<\d>}', name: 'app_ingredient_get')]
    public function get(Ingredient $ingredient): Response
    {
        return $this->json($ingredient);
    }

    #[Route('/ingredient/delete', name: 'app_ingredient_delete')]
    public function delete(IngredientRepository $ingredientRepository, Request $request): Response
    {
        return $this->deleteEntity($ingredientRepository, $request);
    }
}
