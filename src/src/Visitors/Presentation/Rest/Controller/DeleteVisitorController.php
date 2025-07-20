<?php

declare(strict_types=1);

namespace App\Visitors\Presentation\Rest\Controller;

use JsonException;
use App\Visitors\Application\Command\DeleteVisitor\DeleteVisitorCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/api/visitor/delete', name: 'api_delete_visitor', methods: ['DELETE'])]
#[OA\Delete(
    path: '/api/visitor/delete',
    summary: 'Delete a visitor',
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
class DeleteVisitorController extends AbstractController
{
    /**
     * @throws JsonException
     */
    public function __invoke(Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $command = new DeleteVisitorCommand(ulid: $data['ulid']);

        $commandBus->dispatch($command);

        return new JsonResponse(['status' => 'deleted'], 204);
    }
}