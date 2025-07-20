<?php

declare(strict_types=1);

namespace App\Movies\Presentation\Rest\Controller;

use App\Movies\Application\Command\UpdateMovie\UpdateMovieCommand;
use App\Movies\Application\DTO\MovieDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use JsonException;
use OpenApi\Attributes as OA;

#[Route('/api/movie/update', name: 'api_update_movie', methods: ['PUT'])]
#[OA\Put(
    path: '/api/movie/update',
    summary: 'Update a movie',
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["ulid", "title", "releaseDate"],
            properties: [
                new OA\Property(property: "ulid", type: "string"),
                new OA\Property(property: "title", type: "string"),
                new OA\Property(property: "releaseDate", type: "string", format: "date")
            ]
        )
    ),
    responses: [
        new OA\Response(response: 200, description: 'Updated'),
        new OA\Response(response: 400, description: 'Bad Request'),
    ]
)]
class UpdateMovieController extends AbstractController
{
    /**
     * @throws JsonException
     */
    public function __invoke(Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $command = new UpdateMovieCommand(
            movie: new MovieDTO($data['ulid'], $data['title'], $data['releaseDate'])
        );

        $commandBus->dispatch($command);

        return new JsonResponse(['status' => 'updated'], 200);
    }
}