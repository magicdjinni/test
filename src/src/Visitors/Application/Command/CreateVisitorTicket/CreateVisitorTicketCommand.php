<?php

declare(strict_types=1);

namespace App\Visitors\Application\Command\CreateVisitorTicket;

use App\Shared\Application\Command\CommandInterface;

class CreateVisitorTicketCommand implements CommandInterface
{
    public function __construct(
        public readonly string $visitorUlid,
        public readonly string $movieSessionUlid,
        public readonly float $price
    ) {
    }
}