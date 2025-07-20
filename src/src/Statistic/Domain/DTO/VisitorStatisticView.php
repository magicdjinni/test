<?php

declare(strict_types=1);

namespace App\Statistic\Domain\DTO;

class VisitorStatisticView
{
    public function __construct(
        public string $visitorEmail,
        public int $purchasedCount,
        public float $purchasedSum,
        public int $cancelledCount,
        public float $cancelledSum
    ) {}
}