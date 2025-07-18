<?php

declare(strict_types=1);

namespace App\Visitors\Presentation\Rest\Controller;

use App\Visitors\Application\Command\UpdateVisitor\UpdateVisitorCommand;
use App\Visitors\Application\DTO\VisitorDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use JsonException;
use OpenApi\Attributes as OA;

#[Route('/api/visitor/update', name: 'api_update_visitor', methods: ['PUT'])]
#[OA\Put(
    path: '/api/visitor/update',
    summary: 'Update a visitor',
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["ulid", "email", "password"],
            properties: [
                new OA\Property(property: "ulid", type: "string"),
                new OA\Property(property: "email", type: "string"),
                new OA\Property(property: "password", type: "string")
            ]
        )
    ),
    responses: [
        new OA\Response(response: 200, description: 'Updated'),
        new OA\Response(response: 400, description: 'Bad Request'),
    ]
)]
class UpdateVisitorController extends AbstractController
{
    /**
     * @throws JsonException
     */
    public function __invoke(Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $command = new UpdateVisitorCommand(
            password: $data['password'],
            visitor: new VisitorDTO($data['ulid'], $data['email'])
        );

        $commandBus->dispatch($command);

        return new JsonResponse(['status' => 'updated'], 200);
    }
}