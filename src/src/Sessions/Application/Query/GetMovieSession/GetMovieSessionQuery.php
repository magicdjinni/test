<?php

declare(strict_types=1);

namespace App\Sessions\Application\Query\GetMovieSession;

use App\Shared\Application\Query\QueryInterface;

final class GetMovieSessionQuery implements QueryInterface
{
    public function __construct(public readonly string $ulid)
    {
    }
}