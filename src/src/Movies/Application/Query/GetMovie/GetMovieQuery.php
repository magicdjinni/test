<?php

declare(strict_types=1);

namespace App\Movies\Application\Query\GetMovie;

use App\Shared\Application\Query\QueryInterface;

final class GetMovieQuery implements QueryInterface
{
    public function __construct(public readonly string $ulid)
    {
    }
}