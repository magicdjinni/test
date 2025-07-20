<?php

declare(strict_types=1);

namespace App\Visitors\Presentation\Rest\Controller;

use App\Visitors\Application\Command\CreateVisitorTicket\CreateVisitorTicketCommand;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/api/visitor/ticket/create', name: 'api_create_visitor_ticket', methods: ['POST'])]
#[OA\Post(
    path: '/api/visitor/ticket/create',
    summary: 'Create ticket for a visitor',
    responses: [
        new OA\Response(response: 201, description: 'Created'),
        new OA\Response(response: 400, description: 'Bad Request'),
    ]
)]
class VisitorTicketBuyController extends AbstractController
{
    /**
     * @throws JsonException
     */
    public function __invoke(Request $request, MessageBusInterface $commandBus): JsonResponse
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $command = new CreateVisitorTicketCommand(
            visitorUlid: $data['visitorUlid'],
            movieSessionUlid: $data['movieSessionUlid'],
            price: $data['price'],
        );

        $commandBus->dispatch($command);

        return new JsonResponse(['status' => 'created'], 201);
    }
}