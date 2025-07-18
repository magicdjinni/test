<?php

declare(strict_types=1);

namespace App\Sessions\Application\Command\CreateMovieSession;

use App\Shared\Application\Command\CommandInterface;

final class CreateMovieSessionCommand implements CommandInterface
{
    public function __construct(
        public readonly string $movieUlid,
        public readonly string $startDate, // например "2024-07-01"
        public readonly float $price,
    ) {
    }
}