<?php

namespace App\Controller;

use App\Entity\Label;
use App\Repository\LabelRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LabelController extends BaseController
{
    #[Route('/label/list', name: 'app_label_list')]
    public function list(LabelRepository $labelRepository, Request $request): Response
    {
        return $this->fetchList($labelRepository, $request);
    }

    #[Route('/label/get/{id<\d>}', name: 'app_label_get')]
    public function get(Label $label): Response
    {
        return $this->json($label);
    }
}
