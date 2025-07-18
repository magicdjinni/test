<?php

declare(strict_types=1);

namespace App\Visitors\Application\Command\UpdateVisitor;

use App\Shared\Application\Command\CommandInterface;
use App\Visitors\Application\DTO\VisitorDTO;

class UpdateVisitorCommand implements CommandInterface
{
    public function __construct(
        public readonly string $password,
        public VisitorDTO $visitor
    ) {
    }
}