<?php

declare(strict_types=1);

namespace App\Movies\Application\Query\GetMovie;

use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Domain\Repository\MovieRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final class GetMovieHandler implements QueryHandlerInterface
{
    public function __construct(private readonly MovieRepositoryInterface $repository)
    {
    }

    /**
     * @param GetMovieQuery $query
     * @return MovieDTO
     */
    public function __invoke(GetMovieQuery $query): MovieDTO
    {
        $movie = $this->repository->get($query->ulid);

        return MovieDTO::fromEntity($movie);
    }
}