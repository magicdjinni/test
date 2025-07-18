<?php

declare(strict_types=1);

namespace App\Movies\Application\Command\UpdateMovie;

use App\Movies\Application\DTO\MovieDTO;
use App\Shared\Application\Command\CommandInterface;

class UpdateMovieCommand implements CommandInterface
{
    public function __construct(
        public MovieDTO $movie
    ) {
    }
}