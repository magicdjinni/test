<?php

declare(strict_types=1);

namespace App\Sessions\Application\Command\DeleteMovieSession;

use App\Shared\Application\Command\CommandInterface;

class DeleteMovieSessionCommand implements CommandInterface
{
    public function __construct(public readonly string $ulid)
    {
    }
}