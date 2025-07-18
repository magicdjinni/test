<?php

declare(strict_types=1);

namespace App\Visitors\Application\Command\DeleteVisitor;

use App\Shared\Application\Command\CommandInterface;

class DeleteVisitorCommand implements CommandInterface
{
    public function __construct(public readonly string $ulid)
    {
    }
}