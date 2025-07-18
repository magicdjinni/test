<?php

declare(strict_types=1);

namespace App\Sessions\Application\DTO;

use App\Sessions\Domain\Entity\MovieSession;

class MovieSessionDTO
{
    public function __construct(
        public string $ulid,
        public string $movieUlid,
        public string $startDate,
        public float $price,
    ) {
    }

    public static function fromEntity(MovieSession $movieSession): self
    {
        return new self(
            $movieSession->getUlid(),
            $movieSession->getMovieUlid(),
            $movieSession->getStartDate()->format('Y-m-d'),
            $movieSession->getPrice()
        );
    }
}