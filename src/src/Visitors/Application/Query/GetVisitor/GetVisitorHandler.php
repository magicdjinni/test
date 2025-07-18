<?php

declare(strict_types=1);

namespace App\Visitors\Application\Query\GetVisitor;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Visitors\Application\DTO\VisitorDTO;
use App\Visitors\Domain\Repository\VisitorRepositoryInterface;

class GetVisitorHandler implements QueryHandlerInterface
{
    public function __construct(private readonly VisitorRepositoryInterface $repository)
    {
    }

    public function __invoke(GetVisitorQuery $query): VisitorDTO
    {
        $visitor = $this->repository->get($query->ulid);

        return VisitorDTO::fromEntity($visitor);
    }
}