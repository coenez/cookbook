<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default')]
    public function index()
    {
        return $this->render('index.html.twig');
    }


    #[Route('/test', name: 'test')]
    public function test(): JsonResponse
    {
        return new JsonResponse(['data' => 'json says hi!']);

    }
}
