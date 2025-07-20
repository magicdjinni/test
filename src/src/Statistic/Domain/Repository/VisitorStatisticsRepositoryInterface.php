<?php

declare(strict_types=1);

namespace App\Statistic\Domain\Repository;

use App\Statistic\Domain\DTO\VisitorStatisticView;

interface VisitorStatisticsRepositoryInterface
{
    /**
     * @param string $visitorEmail
     * @return VisitorStatisticView
     */
    public function getVisitorStatisticByEmail(string $visitorEmail): VisitorStatisticView;

}