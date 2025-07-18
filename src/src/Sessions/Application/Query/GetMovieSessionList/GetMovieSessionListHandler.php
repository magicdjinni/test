<?php

declare(strict_types=1);

namespace App\Sessions\Application\Query\GetMovieSessionList;

use App\Sessions\Application\DTO\MovieSessionDTO;
use App\Sessions\Domain\Repository\MovieSessionRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

class GetMovieSessionListHandler implements QueryHandlerInterface
{
    public function __construct(private readonly MovieSessionRepositoryInterface $repository)
    {
    }

    public function __invoke(GetMovieSessionListQuery $query): array
    {
        $response = [];
        foreach ($this->repository->findAll() as $movieSession) {
            $response[] = MovieSessionDTO::fromEntity($movieSession);
        }

        return $response;
    }
}