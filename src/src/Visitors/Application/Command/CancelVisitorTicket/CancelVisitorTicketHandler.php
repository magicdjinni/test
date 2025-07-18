<?php

declare(strict_types=1);

namespace App\Visitors\Application\Command\CancelVisitorTicket;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Visitors\Domain\Repository\TicketRepositoryInterface;

class CancelVisitorTicketHandler implements CommandHandlerInterface
{
    public function __construct(private readonly TicketRepositoryInterface $repository)
    {
    }

    public function __invoke(CancelVisitorTicketCommand $command): void
    {
        $this->repository->cancel($command->ulid);
    }
}