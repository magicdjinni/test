<?php

declare(strict_types=1);

namespace App\Movies\Presentation\Rest\Controller;

use App\Movies\Application\Command\CreateMovie\CreateMovieCommand;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/api/movie/create', name: 'api_create_movie', methods: ['POST'])]
#[OA\Post(
    path: '/api/movie/create',
    summary: 'Create a new movie',
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["title", "releaseDate"],
            properties: [
                new OA\Property(property: "title", type: "string"),
                new OA\Property(property: "releaseDate", type: "string", format: "date")
            ]
        )
    ),
    responses: [
        new OA\Response(response: 201, description: 'Created'),
        new OA\Response(response: 400, description: 'Bad Request'),
    ]
)]
class CreateMovieController extends AbstractController
{
    /**
     * @throws JsonException
     */
    public function __invoke(Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $command = new CreateMovieCommand(
            title: $data['title'],
            releaseDate: $data['releaseDate']
        );

        $commandBus->dispatch($command);

        return new JsonResponse(['status' => 'created'], 201);
    }
}