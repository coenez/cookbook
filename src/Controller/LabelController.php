<?php

namespace App\Controller;

use App\Entity\Label;
use App\Repository\LabelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LabelController extends AbstractController
{
    #[Route('/label/list', name: 'app_label_list')]
    public function list(LabelRepository $labelRepository): Response
    {
        return $this->json($labelRepository->findAll());
    }

    #[Route('/label/get/{id<\d>}', name: 'app_label_get')]
    public function get(Label $label): Response
    {
        return $this->json($label);
    }
}
