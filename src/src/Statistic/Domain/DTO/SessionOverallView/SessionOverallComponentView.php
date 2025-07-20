<?php

declare(strict_types=1);

namespace App\Statistic\Domain\DTO\SessionOverallView;

use DateTimeImmutable;

class SessionOverallComponentView
{
    public function __construct(
        public DateTimeImmutable $startDate,
        public array $visitorsEmails,
        public int $ticketsSold,
        public float $totalSum
    ) {}
}