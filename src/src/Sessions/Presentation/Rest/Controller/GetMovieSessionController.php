<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\Rest\Controller;

use App\Sessions\Application\DTO\MovieSessionDTO;
use App\Sessions\Application\Query\GetMovieSession\GetMovieSessionQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/api/moviesession/get/{id}', name: 'api_get_moviesession', methods: ['GET'])]
#[OA\Get(
    path: '/api/moviesession/get/{id}',
    summary: 'Get a movie session by ulid',
    parameters: [
        new OA\Parameter(
            name: "ulid",
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
                    new OA\Property(property: "ulid", type: "string"),
                    new OA\Property(property: "title", type: "string"),
                    new OA\Property(property: "releaseDate", type: "string", format: "date")
                ]
            )
        ),
        new OA\Response(response: 404, description: "Not Found")
    ]
)]
class GetMovieSessionController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function __invoke(string $id): JsonResponse
    {
        /** @var MovieSessionDTO $movie */
        $movie = $this->handle(new GetMovieSessionQuery($id));

        return new JsonResponse([
            'ulid' => $movie->ulid,
            'movieUlid' => $movie->movieUlid,
            'startDate' => $movie->startDate,
            'price' => $movie->price,
        ]);
    }
}