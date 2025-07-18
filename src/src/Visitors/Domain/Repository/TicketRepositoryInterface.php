<?php

declare(strict_types=1);

namespace App\Visitors\Domain\Repository;

use App\Visitors\Domain\Entity\Ticket;

interface TicketRepositoryInterface
{
    public function add(Ticket $ticket): void;

    public function cancel(string $ulid): void;

    /** @return Ticket[] */
    public function findAll(): array;

    public function findBy(array $criteria): array;
}