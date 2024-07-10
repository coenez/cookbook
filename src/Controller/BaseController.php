<?php
namespace App\Controller;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController {

    public function extractFromRequest(Request $request, array $params): array
    {
        $result = [];
        foreach($params as $param) {
            $result[$param] = $request->get($param);
        }
        return $result;
    }

    public function fetchList(ServiceEntityRepository $repository, Request $request) {
        $params = $this->extractFromRequest($request, ['search', 'orderBy', 'limit', 'offset']);
        extract($params);

        return $this->json([
            'result' => $repository->findBySearchAndSort((string)$search, (string)$orderBy, (int)$limit, (int)$offset),
            'totalCount' => $repository->count()
        ]);
    }


}