<?php

declare(strict_types=1);

namespace App\Visitors\Domain\Entity;

use DateTimeImmutable;

class Ticket
{
    public function __construct(
        private readonly string $ulid,
        private readonly string $visitorUlid,
        private readonly string $movieSessionUlid,
        private readonly string $status,
        private readonly float $soldPrice,
        private DateTimeImmutable $soldDate
    ) {
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getVisitorUlid(): string
    {
        return $this->visitorUlid;
    }

    public function getMovieSessionUlid(): string
    {
        return $this->movieSessionUlid;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getSoldPrice(): float
    {
        return $this->soldPrice;
    }

    public function getSoldDate(): DateTimeImmutable
    {
        return $this->soldDate;
    }
}