<?php

declare(strict_types=1);

namespace App\Visitors\Presentation\Rest\Controller;

use App\Visitors\Application\Command\CancelVisitorTicket\CancelVisitorTicketCommand;
use JsonException;
use App\Visitors\Application\Command\DeleteVisitor\DeleteVisitorCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/api/visitor/ticket/cancel', name: 'api_cancel_visitor_ticket', methods: ['PUT'])]
#[OA\Put(
    path: '/api/visitor/ticket/cancel',
    summary: 'Set cancel status to a ticket',
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
        new OA\Response(response: 200, description: 'Updated'),
        new OA\Response(response: 400, description: 'Bad Request'),
    ]
)]
class CancelVisitorTicketController extends AbstractController
{
    /**
     * @throws JsonException
     */
    public function __invoke(Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $command = new CancelVisitorTicketCommand(ulid: $data['ulid']);

        $commandBus->dispatch($command);

        return new JsonResponse(['status' => 'deleted'], 204);
    }
}