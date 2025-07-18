<?php

declare(strict_types=1);

namespace App\Sessions\Application\Query\GetMovieSession;

use App\Sessions\Application\DTO\MovieSessionDTO;
use App\Sessions\Domain\Repository\MovieSessionRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final class GetMovieSessionHandler implements QueryHandlerInterface
{
    public function __construct(private readonly MovieSessionRepositoryInterface $repository)
    {
    }

    /**
     * @param GetMovieSessionQuery $query
     * @return MovieSessionDTO
     */
    public function __invoke(GetMovieSessionQuery $query): MovieSessionDTO
    {
        $movieSession = $this->repository->get($query->ulid);

        return MovieSessionDTO::fromEntity($movieSession);
    }
}