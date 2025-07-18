<?php

declare(strict_types=1);

namespace App\Sessions\Presentation\Rest\Controller;

use App\Sessions\Application\Query\GetMovieSessionList\GetMovieSessionListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[Route('/api/moviesession/getlist', name: 'api_get_all_moviesessions', methods: ['GET'])]
#[OA\Get(
    path: '/api/moviesession/getlist',
    summary: 'Get movie session list',
    responses: [
        new OA\Response(response: 200, description: "OK"),
        new OA\Response(response: 404, description: "Not Found")
    ]
)]
class GetMovieSessionListController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function __invoke(): JsonResponse
    {
        $movies = $this->handle(new GetMovieSessionListQuery());

        return new JsonResponse($movies);
    }
}