<?php

declare(strict_types=1);

namespace App\Statistic\Infrastructure\Repository;

use App\Statistic\Domain\DTO\SessionOverallView\SessionOverallComponentView;
use App\Statistic\Domain\DTO\SessionOverallView\SessionOverallView;
use App\Statistic\Domain\DTO\SessionStatisticView;
use App\Statistic\Domain\Repository\SessionStatisticsRepositoryInterface;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;


class SessionStatisticsRepository implements SessionStatisticsRepositoryInterface
{
    public function __construct(private readonly Connection $connection) {}

    /**
     * @throws Exception
     */
    public function getSessionStatisticByDate(DateTimeImmutable $from, DateTimeImmutable $to): array
    {
        $sql = <<<SQL
            SELECT
                m.title,
                ms.start_date,
                COUNT(t.ulid) AS tickets_sold,
                SUM(ms.price) AS total_sum
            FROM ticket t
            LEFT JOIN moviesession ms ON t.movie_session_ulid = ms.ulid
            LEFT JOIN movies m ON ms.movie_ulid = m.ulid
            WHERE t.status = 'purchased'
              AND ms.start_date BETWEEN :from AND :to
            GROUP BY m.title, ms.start_date
            ORDER BY total_sum DESC
        SQL;

        $stmt = $this->connection->executeQuery($sql, [
            'from' => $from->format('Y-m-d 00:00:00'),
            'to' => $to->format('Y-m-d 23:59:59'),
        ]);

        return array_map(function (array $row) {
            return new SessionStatisticView(
                $row['title'],
                new DateTimeImmutable($row['start_date']),
                (int)$row['tickets_sold'],
                (float)$row['total_sum']
            );
        }, $stmt->fetchAllAssociative());
    }

    /**
     * @throws Exception
     */
    public function getSessionStatisticOverall(): array
    {
        $sql = <<<SQL
            SELECT
                m.title AS movie,
                ms.start_date,
                GROUP_CONCAT(DISTINCT v.email) AS visitors,
                COUNT(t.ulid) AS tickets_sold,
                SUM(ms.price) AS total_sum
            FROM movies m
            LEFT JOIN moviesession ms ON ms.movie_ulid = m.ulid
            LEFT JOIN ticket t ON t.movie_session_ulid = ms.ulid AND t.status = 'purchased'
            LEFT JOIN visitor v ON t.visitor_ulid = v.ulid
            GROUP BY m.ulid, m.title, ms.ulid, ms.start_date, ms.price
            ORDER BY ms.start_date DESC;
        SQL;

        $stmt = $this->connection->executeQuery($sql);
        $data = $stmt->fetchAllAssociative();

        $result = [];
        foreach ($data as $row) {
            $visitors = explode(',', $row['visitors']);
            $result[$row['movie']][] = new SessionOverallComponentView(
                new DateTimeImmutable($row['start_date']),
                array_filter($visitors),
                (int)$row['tickets_sold'],
                (float)$row['total_sum']
            );
        }

        $finalResult = [];
        foreach ($result as $movieTitle => $components) {
            $finalResult[] = new SessionOverallView(
                $movieTitle,
                $components
            );
        }

        return $finalResult;
    }
}