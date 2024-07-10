<?php

namespace App\Controller;

use App\Entity\Label;
use App\Repository\LabelRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/label/save', name: 'app_label_save')]
    public function save(LabelRepository $labelRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = $request->getPayload();
        $label = new Label();
        if ($data->get('id')) {
            $label = $labelRepository->find($data->get('id'));
        }

        $label->setName($data->get('name'));
        $entityManager->persist($label);
        $entityManager->flush();

        return $this->json($label);
    }

    #[Route('/label/get/{id<\d>}', name: 'app_label_get')]
    public function get(Label $label): Response
    {
        return $this->json($label);
    }
}
