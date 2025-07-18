<?php

declare(strict_types=1);

namespace App\Visitors\Application\Command\CreateVisitor;

use App\Shared\Application\Command\CommandInterface;

class CreateVisitorCommand implements CommandInterface
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
    }
}