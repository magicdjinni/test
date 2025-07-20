<?php

declare(strict_types=1);

namespace App\Visitors\Presentation\Rest\Controller;

use App\Visitors\Application\Command\CreateVisitor\CreateVisitorCommand;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/api/visitor/create', name: 'api_create_visitor', methods: ['POST'])]
#[OA\Post(
    path: '/api/visitor/create',
    summary: 'Create a new visitor',
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
class CreateVisitorController extends AbstractController
{
    /**
     * @throws JsonException
     */
    public function __invoke(Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $command = new CreateVisitorCommand(
            email: $data['email'],
            password: $data['password']
        );

        $commandBus->dispatch($command);

        return new JsonResponse(['status' => 'created'], 201);
    }
}