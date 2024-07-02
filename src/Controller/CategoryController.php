<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/list', name: 'app_category_list')]
    public function list(CategoryRepository $categoryRepository): Response
    {
        return $this->json($categoryRepository->findAll());
    }

    #[Route('/category/get/{id<\d>}', name: 'app_category_get')]
    public function get(Category $category): Response
    {
        return $this->json($category);
    }
}
