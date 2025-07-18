<?php

declare(strict_types=1);

namespace App\Visitors\Application\Query\GetVisitor;

use App\Shared\Application\Query\QueryInterface;

class GetVisitorQuery implements QueryInterface
{
    public function __construct(public readonly string $ulid)
    {
    }
}