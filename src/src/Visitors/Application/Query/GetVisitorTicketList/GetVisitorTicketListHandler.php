<?php

declare(strict_types=1);

namespace App\Visitors\Application\Query\GetVisitorTicketList;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Visitors\Application\DTO\TicketDTO;
use App\Visitors\Domain\Repository\TicketRepositoryInterface;

class GetVisitorTicketListHandler implements QueryHandlerInterface
{
    public function __construct(private readonly TicketRepositoryInterface $repository)
    {
    }

    public function __invoke(GetVisitorTicketListQuery $query): array
    {
        $response = [];
        foreach ($this->repository->findBy(['visitorUlid' => $query->visitorUlid]) as $visitorTicket) {
            $response[] = TicketDTO::fromEntity($visitorTicket);
        }

        return $response;
    }
}