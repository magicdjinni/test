<?php

declare(strict_types=1);

namespace App\Statistic\Presentation\Rest;

use App\Statistic\Domain\Repository\SessionStatisticsRepositoryInterface;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use OpenApi\Attributes as OA;

class SessionStatisticsController
{
    public function __construct(
        private readonly SessionStatisticsRepositoryInterface $repository,
        private readonly CacheInterface $cache
    ) {}

    #[Route('/api/statistic/date/{date}', name: 'api_get_session_statistic_by_date', methods: ['GET'])]
    #[OA\Get(
        path: '/api/statistic/date/{date}',
        summary: 'Session statistic by date',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["date"],
                properties: [
                    new OA\Property(property: "date", type: "date format: YYYY-MM-DD")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Successful'),
            new OA\Response(response: 400, description: 'Bad Request'),
        ]
    )]
    public function getSessionStatisticByDate(string $date): JsonResponse
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            throw new BadRequestHttpException("Invalid date format. Use YYYY-MM-DD.");
        }

        try {
            $from = new DateTimeImmutable($date);
        } catch (\Exception $e) {
            throw new BadRequestHttpException("Invalid date.");
        }

        $to = $from;
        $cacheKey = "statistic_sessions_day_$date";

        $data = $this->cache->get($cacheKey, function (ItemInterface $item) use ($from, $to) {
            $item->expiresAfter(3600);
            return $this->repository->getSessionStatisticByDate($from, $to);
        });

        return new JsonResponse($data);
    }

    #[Route('/api/statistic/dates', name: 'api_get_session_statistic_by_dates', methods: ['GET'])]
    #[OA\Get(
        path: '/api/statistic/dates{from}{to}',
        summary: 'Session statistic by dates range',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["from", "to"],
                properties: [
                    new OA\Property(property: "from", type: "date format: YYYY-MM-DD"),
                    new OA\Property(property: "to", type: "date format: YYYY-MM-DD")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Successful'),
            new OA\Response(response: 400, description: 'Bad Request'),
        ]
    )]
    public function getSessionStatisticByRange(Request $request): JsonResponse
    {
        $from = $request->query->get('from');
        $to = $request->query->get('to');

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $from) ||
            !preg_match('/^\d{4}-\d{2}-\d{2}$/', $to)) {

            throw new BadRequestHttpException("Invalid date format. Use YYYY-MM-DD.");
        }

        try {
            $fromDate = new DateTimeImmutable($from);
            $toDate = new DateTimeImmutable($to);
        } catch (\Exception $e) {
            throw new BadRequestHttpException("Invalid date.");
        }

        $cacheKey = "statistic_sessions_day_".$from."_".$to;

        $data = $this->cache->get($cacheKey, function (ItemInterface $item) use ($fromDate, $toDate) {
            $item->expiresAfter(3600);
            return $this->repository->getSessionStatisticByDate($fromDate, $toDate);
        });

        return new JsonResponse($data);
    }

    #[Route('/api/statistic/overall', name: 'api_get_session_statistic_overall', methods: ['GET'])]
    #[OA\Get(
        path: '/api/statistic/overall',
        summary: 'Session overall statistic',
        responses: [
            new OA\Response(response: 200, description: 'Successful'),
            new OA\Response(response: 400, description: 'Bad Request'),
        ]
    )]
    public function getSessionStatisticOverall(): JsonResponse
    {
        return new JsonResponse($this->repository->getSessionStatisticOverall());
    }
}