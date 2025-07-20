<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\Rest\Controller;

use App\Sessions\Application\Command\UpdateMovieSession\UpdateMovieSessionCommand;
use App\Sessions\Application\DTO\MovieSessionDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use JsonException;
use OpenApi\Attributes as OA;

#[Route('/api/moviesession/update', name: 'api_update_moviesession', methods: ['PUT'])]
#[OA\Put(
    path: '/api/moviesession/update',
    summary: 'Update movie session',
    responses: [
        new OA\Response(response: 200, description: "OK"),
        new OA\Response(response: 404, description: "Not Found")
    ]
)]
class UpdateMovieSessionController extends AbstractController
{
    /**
     * @throws JsonException
     */
    public function __invoke(Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $command = new UpdateMovieSessionCommand(
            movieSession: new MovieSessionDTO(
                $data['ulid'],
                $data['movieUlid'],
                $data['startDate'],
                (float)$data['price'],
            )
        );

        $commandBus->dispatch($command);

        return new JsonResponse(['status' => 'updated'], 200);
    }
}