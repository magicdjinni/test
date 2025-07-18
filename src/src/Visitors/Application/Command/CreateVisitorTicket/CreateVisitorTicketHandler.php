<?php

declare(strict_types=1);

namespace App\Visitors\Application\Command\CreateVisitorTicket;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Infrastructure\Service\SymfonyUuidGenerator;
use App\Visitors\Domain\Entity\Ticket;
use App\Visitors\Domain\Repository\TicketRepositoryInterface;
use DateTimeImmutable;

class CreateVisitorTicketHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly TicketRepositoryInterface $repository,
    )
    {
    }

    public function __invoke(CreateVisitorTicketCommand $command): string
    {
        $ticket = new Ticket(
            ulid: SymfonyUuidGenerator::generate(),
            visitorUlid: $command->visitorUlid,
            movieSessionUlid: $command->movieSessionUlid,
            status: 'purchased',
            soldPrice: $command->price,
            soldDate:  new DateTimeImmutable(),
        );

        $this->repository->add($ticket);

        return $ticket->getUlid();
    }
}