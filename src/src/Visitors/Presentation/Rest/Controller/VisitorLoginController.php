<?php

declare(strict_types=1);

namespace App\Visitors\Presentation\Rest\Controller;

use App\Visitors\Infrastructure\Repository\VisitorRepository;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Attributes as OA;

#[Route('/api/visitor/login', name: 'api_visitor_login', methods: ['POST'])]
#[OA\Post(
    path: '/api/visitor/login',
    summary: 'Login by existing visitor',
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["email", "password"],
            properties: [
                new OA\Property(property: "email", type: "string"),
                new OA\Property(property: "password", type: "string")
            ]
        )
    ),
    responses: [
        new OA\Response(response: 201, description: 'Created'),
        new OA\Response(response: 400, description: 'Bad Request'),
    ]
)]
class VisitorLoginController extends AbstractController
{
    /**
     * @throws JsonException
     */
    public function __invoke(
        Request $request,
        VisitorRepository $visitorRepo,
        UserPasswordHasherInterface $hasher
    ): JsonResponse {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (!$email || !$password) {
            return new JsonResponse(['error' => 'Email and password required'], 400);
        }

        $visitor = $visitorRepo->findOneBy(['email' => $email]);

        if ($visitor === null || $hasher->isPasswordValid($visitor, $password) === false) {
            return new JsonResponse(['error' => 'Invalid credentials'], 401);
        }

        // Для простоты
        return new JsonResponse([
            'ulid' => $visitor->getUlid(),
            'email' => $visitor->getEmail(),
            'token' => base64_encode($visitor->getUlid()) // простой "токен"
        ]);
    }
}