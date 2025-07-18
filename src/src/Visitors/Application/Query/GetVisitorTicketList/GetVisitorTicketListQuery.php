<?php

declare(strict_types=1);

namespace App\Visitors\Application\Query\GetVisitorTicketList;

use App\Shared\Application\Query\QueryInterface;

class GetVisitorTicketListQuery implements QueryInterface
{
    public function __construct(public readonly string $visitorUlid)
    {
    }
}