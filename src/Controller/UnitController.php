<?php

namespace App\Controller;

use App\Entity\Unit;
use App\Repository\UnitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UnitController extends BaseController
{
    #[Route('/unit/list', name: 'app_unit_list')]
    public function list(UnitRepository $unitRepository, Request $request): Response
    {
        return $this->fetchList($unitRepository, $request);
    }

    #[Route('/unit/save', name: 'app_unit_save')]
    public function save(UnitRepository $unitRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $data = $request->getPayload();
        $unit = new Unit();
        if ($data->get('id')) {
            $unit = $unitRepository->find($data->get('id'));
        }

        $unit->setName($data->get('name'));
        $unit->setValue($data->get('value'));
        $entityManager->persist($unit);
        $entityManager->flush();

        return $this->json($unit);
    }
}
