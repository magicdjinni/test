<?php

declare(strict_types=1);

namespace App\Statistic\Presentation\Rest;

use App\Statistic\Domain\Repository\VisitorStatisticsRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

class VisitorStatisticController
{
    public function __construct(private readonly VisitorStatisticsRepositoryInterface $repository) {}

    #[Route('/api/statistic/visitor/{email}', name: 'api_get_visitor_statistic_by_email', methods: ['GET'])]
    #[OA\Get(
        path: '/api/statistic/visitor/{email}',
        summary: 'Visitor statistic by email',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email"],
                properties: [
                    new OA\Property(property: "email", type: "email format: <EMAIL>")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Successful'),
            new OA\Response(response: 400, description: 'Bad Request'),
        ]
    )]
    public function getSessionStatisticByDate(string $email): JsonResponse
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new BadRequestHttpException('Invalid email format');
        }

        return new JsonResponse($this->repository->getVisitorStatisticByEmail($email));
    }
}