<?php

declare(strict_types=1);

namespace App\Visitors\Presentation\Rest\Controller;

use App\Movies\Application\Query\GetMovieList\GetMovieListQuery;
use App\Visitors\Application\Query\GetVisitorList\GetVisitorListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/api/visitor/getlist', name: 'api_get_all_visitors', methods: ['GET'])]
#[OA\Get(
    path: '/api/visitor/getlist',
    summary: 'Get visitor list',
    responses: [
        new OA\Response(response: 200, description: "OK"),
        new OA\Response(response: 404, description: "Not Found")
    ]
)]
class GetVisitorListController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function __invoke(): JsonResponse
    {
        $visitors = $this->handle(new GetVisitorListQuery());

        return new JsonResponse($visitors);
    }
}