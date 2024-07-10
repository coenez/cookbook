<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends BaseController
{
    #[Route('/category/list', name: 'app_category_list')]
    public function list(CategoryRepository $categoryRepository, Request $request): Response
    {
        return $this->fetchList($categoryRepository, $request);
    }

    #[Route('/category/save', name: 'app_category_save')]
    public function save(CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = $request->getPayload();
        $category = new Category();
        if ($data->get('id')) {
            $category = $categoryRepository->find($data->get('id'));
        }

        $category->setName($data->get('name'));
        $entityManager->persist($category);
        $entityManager->flush();

        return $this->json($category);
    }

    #[Route('/category/get/{id<\d>}', name: 'app_category_get')]
    public function get(Category $category): Response
    {
        return $this->json($category);
    }
}
