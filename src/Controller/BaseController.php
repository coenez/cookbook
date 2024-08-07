<?php
namespace App\Controller;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    public function fetchList(ServiceEntityRepository $repository, Request $request): JsonResponse {
        $params = $this->extractFromRequest($request, ['search', 'orderBy', 'limit', 'offset']);
        extract($params);

        return $this->json([
            'result' => $repository->findBySearchAndSort((string)$search, (string)$orderBy, (int)$limit, (int)$offset),
            'totalCount' => $repository->count()
        ]);
    }

    public function deleteEntity(ServiceEntityRepository $repository, Request $request): JsonResponse
    {
        $repository->deleteEntity($request->get('id'));
        return $this->json([
            'result' => true
        ]);
    }

    public function convertJsonPayload(Request $request): Request {
        $request->request->replace(json_decode($request->getContent(), true));
        return $request;
    }


}