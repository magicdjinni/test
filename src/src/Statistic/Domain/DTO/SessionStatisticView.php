<?php

declare(strict_types=1);

namespace App\Statistic\Domain\DTO;

use DateTimeImmutable;

class SessionStatisticView
{
    public function __construct(
        public string $title,
        public DateTimeImmutable $startDate,
        public int $ticketsSold,
        public float $totalSum
    ) {}
}