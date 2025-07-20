<?php

declare(strict_types=1);

namespace App\Statistic\Infrastructure\Repository;

use App\Statistic\Domain\DTO\VisitorStatisticView;
use App\Statistic\Domain\Repository\VisitorStatisticsRepositoryInterface;
use Doctrine\DBAL\Connection;

class VisitorStatisticsRepository implements VisitorStatisticsRepositoryInterface
{
    public function __construct(private readonly Connection $connection) {}

    public function getVisitorStatisticByEmail(string $visitorEmail): VisitorStatisticView
    {

        $sql = <<<SQL
            SELECT
                v.email,
        
                COUNT(CASE WHEN t.status = 'purchased' THEN 1 END) AS purchased_count,
                SUM(CASE WHEN t.status = 'purchased' THEN ms.price ELSE 0 END) AS purchased_sum,
        
                COUNT(CASE WHEN t.status = 'cancelled' THEN 1 END) AS cancelled_count,
                SUM(CASE WHEN t.status = 'cancelled' THEN ms.price ELSE 0 END) AS cancelled_sum
        
            FROM visitor v
            LEFT JOIN ticket t ON t.visitor_ulid = v.ulid
            LEFT JOIN moviesession ms ON t.movie_session_ulid = ms.ulid
        
            GROUP BY v.ulid, v.email
            ORDER BY purchased_sum DESC;
        SQL;

        $stmt = $this->connection->executeQuery($sql, ['email' => $visitorEmail]);
        $data = $stmt->fetchAssociative();

        return new VisitorStatisticView(
            $data['email'],
            $data['purchased_count'],
            (float)$data['purchased_sum'],
            $data['cancelled_count'],
            (float)$data['cancelled_sum']
        );
    }
}