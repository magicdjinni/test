<?php

declare(strict_types=1);

namespace App\Movies\Presentation\Rest\Controller;

use App\Movies\Application\Query\GetMovieList\GetMovieListQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/api/movie/getlist', name: 'api_get_all_movies', methods: ['GET'])]
#[OA\Get(
    path: '/api/movie/getlist',
    summary: 'Get movie list',
    responses: [
        new OA\Response(response: 200, description: "OK"),
        new OA\Response(response: 404, description: "Not Found")
    ]
)]
class GetMovieListController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function __invoke(): JsonResponse
    {
        $movies = $this->handle(new GetMovieListQuery());

        return new JsonResponse($movies);
    }
}