<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\Rest\Controller;

use App\Sessions\Application\Command\CreateMovieSession\CreateMovieSessionCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/api/moviesession/create', name: 'api_create_moviesession', methods: ['POST'])]
#[OA\Post(
    path: '/api/moviesession/create',
    summary: 'Create a new movie session',
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["movieUlid", "startDate", "price"],
            properties: [
                new OA\Property(property: "movieUlid", type: "string"),
                new OA\Property(property: "startDate", type: "string", format: "date"),
                new OA\Property(property: "price", type: "float"),
            ]
        )
    ),
    responses: [
        new OA\Response(response: 201, description: 'Created'),
        new OA\Response(response: 400, description: 'Bad Request'),
    ]
)]
class CreateMovieSessionController extends AbstractController
{
    /**
     * @throws JsonException
     */
    public function __invoke(Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $command = new CreateMovieSessionCommand(
            movieUlid: $data['movieUlid'],
            startDate: $data['startDate'],
            price: (float)$data['price'],
        );

        $commandBus->dispatch($command);

        return new JsonResponse(['status' => 'created'], 201);
    }
}