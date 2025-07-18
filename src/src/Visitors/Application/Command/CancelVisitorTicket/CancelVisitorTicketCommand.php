<?php

declare(strict_types=1);

namespace App\Visitors\Application\Command\CancelVisitorTicket;

use App\Shared\Application\Command\CommandInterface;

class CancelVisitorTicketCommand implements CommandInterface
{
    public function __construct(public readonly string $ulid)
    {
    }
}