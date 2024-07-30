<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\SecurityBundle\Security;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(#[CurrentUser] ?User $user): JsonResponse
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => $user->getName(),
            'roles' => $user->getRoles()
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(Security $security): JsonResponse {
        return $this->json(['success' => true]);
    }

    #[Route('/checkcurrentuser', name: 'app_current_user')]
    public function checkCurrentUser(): JsonResponse {
        $user = $this->getUser();
        if (!$user) {
            throw new \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException('No authenticated user');
        }
        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => $user->getName(),
            'roles' => $user->getRoles()
        ]);
    }
}
