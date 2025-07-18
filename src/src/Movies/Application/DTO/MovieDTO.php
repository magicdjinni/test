<?php

declare(strict_types=1);

namespace App\Movies\Application\DTO;

use App\Movies\Domain\Entity\Movie;

class MovieDTO
{
    public function __construct(
        public string $ulid,
        public string $title,
        public string $releaseDate,
    ) {
    }

    public static function fromEntity(Movie $movie): self
    {
        return new self(
            $movie->getUlid(),
            $movie->getTitle()->value(),
            $movie->getReleaseDate()->format('Y-m-d')
        );
    }
}