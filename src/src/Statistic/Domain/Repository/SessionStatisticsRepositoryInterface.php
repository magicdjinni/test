<?php

declare(strict_types=1);

namespace App\Statistic\Domain\Repository;

use App\Statistic\Domain\DTO\SessionOverallView\SessionOverallView;
use App\Statistic\Domain\DTO\SessionStatisticView;
use DateTimeImmutable;

interface SessionStatisticsRepositoryInterface
{

    /**
     * @param DateTimeImmutable $from
     * @param DateTimeImmutable $to
     * @return SessionStatisticView[]
     */
    public function getSessionStatisticByDate(DateTimeImmutable $from, DateTimeImmutable $to): array;


    /**
     * @return SessionOverallView[]
     */
    public function getSessionStatisticOverall() : array;
}