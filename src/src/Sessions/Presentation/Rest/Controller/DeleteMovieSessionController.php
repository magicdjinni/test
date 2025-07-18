<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\Rest\Controller;

use App\Sessions\Application\Command\DeleteMovieSession\DeleteMovieSessionCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/api/moviesession/delete', name: 'api_delete_moviesession', methods: ['DELETE'])]
#[OA\Delete(
    path: '/api/moviesession/delete',
    summary: 'Delete movie session',
    responses: [
        new OA\Response(response: 204, description: "OK"),
        new OA\Response(response: 404, description: "Not Found")
    ]
)]
class DeleteMovieSessionController extends AbstractController
{
    /**
     * @throws JsonException
     */
    public function __invoke(Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $command = new DeleteMovieSessionCommand(ulid: $data['ulid']);

        $commandBus->dispatch($command);

        return new JsonResponse(['status' => 'deleted'], 204);
    }
}