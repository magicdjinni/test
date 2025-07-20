<?php

declare(strict_types=1);

namespace App\Movies\Presentation\Rest\Controller;

use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Application\Query\GetMovie\GetMovieQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/api/movie/get/{id}', name: 'api_get_movie', methods: ['GET'])]
#[OA\Get(
    path: '/api/movie/get/{id}',
    summary: 'Get a movie by ID',
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
            description: "Movie found",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "id", type: "string"),
                    new OA\Property(property: "title", type: "string"),
                    new OA\Property(property: "releaseDate", type: "string", format: "date")
                ]
            )
        ),
        new OA\Response(response: 404, description: "Not Found")
    ]
)]
class GetMovieController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function __invoke(string $id): JsonResponse
    {
        /** @var MovieDTO $movie */
        $movie = $this->handle(new GetMovieQuery($id));

        return new JsonResponse([
            'ulid' => $movie->ulid,
            'title' => $movie->title,
            'releaseDate' => $movie->releaseDate,
        ]);
    }
}