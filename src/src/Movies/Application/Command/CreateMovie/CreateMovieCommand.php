<?php

declare(strict_types=1);

namespace App\Movies\Application\Command\CreateMovie;

use App\Shared\Application\Command\CommandInterface;

final class CreateMovieCommand implements CommandInterface
{
    public function __construct(
        public readonly string $title,
        public readonly string $releaseDate // например "2024-07-01"
    )
    {
    }
}