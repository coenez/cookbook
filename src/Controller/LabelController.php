<?php

namespace App\Controller;

use App\Entity\Label;
use App\Repository\LabelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class LabelController extends BaseController
{
    #[Route('/label/list', name: 'app_label_list')]
    public function list(LabelRepository $labelRepository, Request $request): Response
    {
        return $this->fetchList($labelRepository, $request);
    }

    #[Route('/label/save', name: 'app_label_save')]
    #[IsGranted('ROLE_ADMIN')]
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

    #[Route('/label/delete', name: 'app_label_delete')]
    public function delete(LabelRepository $labelRepository, Request $request): Response
    {
        return $this->deleteEntity($labelRepository, $request);
    }
}
