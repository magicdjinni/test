<?php

declare(strict_types=1);

namespace App\Visitors\Application\DTO;

use App\Visitors\Domain\Entity\Ticket;

class TicketDTO
{
    public function __construct(
        public string $ulid,
        public string $visitorUlid,
        public string $movieSessionUlid,
        public string $status,
        public string $soldDate,
        public float $soldPrice,
    ) {
    }

    public static function fromEntity(Ticket $ticket): self
    {
        return new self(
            $ticket->getUlid(),
            $ticket->getVisitorUlid(),
            $ticket->getMovieSessionUlid(),
            $ticket->getStatus(),
            $ticket->getSoldDate()->format('Y-m-d H:i:s'),
            $ticket->getSoldPrice(),
        );
    }
}