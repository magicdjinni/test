<?php

declare(strict_types=1);

namespace App\Statistic\Domain\DTO\SessionOverallView;

class SessionOverallView
{
    /**
     * @param string $title
     * @param SessionOverallComponentView[] $sessionOverallComponentView
     */
    public function __construct(
        public string $title,
        public array $sessionOverallComponentView
    ) {}
}