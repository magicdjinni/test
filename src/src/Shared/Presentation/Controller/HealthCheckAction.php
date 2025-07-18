<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/api/healthcheck', name: 'healthcheck', methods: ['GET'])]
#[OA\Get(
    path: '/api/healthcheck',
    summary: 'Check the status of application',
    responses: [
        new OA\Response(
            response: 200,
            description: "Status OK",
        ),
        new OA\Response(response: 404, description: "Not Found")
    ]
)]
class HealthCheckAction
{
    public function __invoke(): Response
    {
        return new JsonResponse(['status' => 'OK']);
    }
}