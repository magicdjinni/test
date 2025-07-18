<?php

declare(strict_types=1);

namespace App\Sessions\Application\Command\UpdateMovieSession;

use App\Sessions\Application\DTO\MovieSessionDTO;
use App\Shared\Application\Command\CommandInterface;

class UpdateMovieSessionCommand implements CommandInterface
{
    public function __construct(
        public MovieSessionDTO $movieSession
    ) {
    }
}