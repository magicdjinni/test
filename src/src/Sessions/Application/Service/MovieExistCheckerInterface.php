<?php

declare(strict_types=1);

namespace App\Sessions\Application\Service;

interface MovieExistCheckerInterface
{
    public function exists(string $movieId): bool;
}