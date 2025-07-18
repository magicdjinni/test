<?php

declare(strict_types=1);

namespace App\Movies\Application\Query\GetMovieList;


use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Domain\Repository\MovieRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

class GetMovieListHandler implements QueryHandlerInterface
{
    public function __construct(private readonly MovieRepositoryInterface $repository)
    {
    }

    public function __invoke(GetMovieListQuery $query): array
    {
        $response = [];
        foreach ($this->repository->findAll() as $movie) {
            $response[] = MovieDTO::fromEntity($movie);
        }

        return $response;
    }
}