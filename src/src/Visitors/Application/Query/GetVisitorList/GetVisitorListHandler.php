<?php

declare(strict_types=1);

namespace App\Visitors\Application\Query\GetVisitorList;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Visitors\Application\DTO\VisitorDTO;
use App\Visitors\Domain\Repository\VisitorRepositoryInterface;

class GetVisitorListHandler implements QueryHandlerInterface
{
    public function __construct(private readonly VisitorRepositoryInterface $repository)
    {
    }

    public function __invoke(GetVisitorListQuery $query): array
    {
        $response = [];
        foreach ($this->repository->findAll() as $visitor) {
            $response[] = VisitorDTO::fromEntity($visitor);
        }

        return $response;
    }
}