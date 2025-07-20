<?php

declare(strict_types=1);

namespace App\Movies\Presentation\Rest\Controller;

use App\Movies\Application\Command\DeleteMovie\DeleteMovieCommand;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/api/movie/delete', name: 'api_delete_movie', methods: ['DELETE'])]
#[OA\Delete(
    path: '/api/movie/delete',
    summary: 'Delete a movie',
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["ulid"],
            properties: [
                new OA\Property(property: "ulid", type: "string")
            ]
        )
    ),
    responses: [
        new OA\Response(response: 204, description: 'Deleted'),
        new OA\Response(response: 400, description: 'Bad Request'),
    ]
)]
class DeleteMovieController extends AbstractController
{
    /**
     * @throws JsonException
     */
    public function __invoke(Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $command = new DeleteMovieCommand(ulid: $data['ulid']);

        $commandBus->dispatch($command);

        return new JsonResponse(['status' => 'deleted'], 204);
    }
}