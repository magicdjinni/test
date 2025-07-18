<?php

declare(strict_types=1);

namespace App\Movies\Application\Command\DeleteMovie;

use App\Shared\Application\Command\CommandInterface;

class DeleteMovieCommand implements CommandInterface
{
    public function __construct(public readonly string $ulid)
    {
    }
}