<?php

declare(strict_types=1);

namespace App\Visitors\Presentation\Rest\Controller;

use App\Visitors\Application\Query\GetVisitorTicketList\GetVisitorTicketListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/api/visitor/ticket/{visitorUlid}', name: 'api_get_all_visitor_ticket', methods: ['GET'])]
#[OA\Get(
    path: '/api/visitor/ticket/{visitorUlid}',
    summary: 'Get visitors tickets by ulid',
)]
class VisitorTicketListController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function __invoke(string $visitorUlid): JsonResponse
    {
        $visitors = $this->handle(new GetVisitorTicketListQuery($visitorUlid));

        return new JsonResponse($visitors);
    }
}