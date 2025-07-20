<?php

declare(strict_types=1);

namespace App\Visitors\Presentation\Rest\Controller;

use App\Visitors\Application\DTO\VisitorDTO;
use App\Visitors\Application\Query\GetVisitor\GetVisitorQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/api/visitor/get/{id}', name: 'api_get_visitor', methods: ['GET'])]
#[OA\Get(
    path: '/api/visitor/get/{id}',
    summary: 'Get a visitor by ID',
    parameters: [
        new OA\Parameter(
            name: "id",
            in: "path",
            required: true,
            schema: new OA\Schema(type: "string")
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: "Visitor found",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "ulid", type: "string"),
                    new OA\Property(property: "email", type: "string"),
                ]
            )
        ),
        new OA\Response(response: 404, description: "Not Found")
    ]
)]
class GetVisitorController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function __invoke(string $id): JsonResponse
    {
        /** @var VisitorDTO $visitor */
        $visitor = $this->handle(new GetVisitorQuery($id));

        return new JsonResponse([
            'ulid' => $visitor->ulid,
            'title' => $visitor->email
        ]);
    }
}