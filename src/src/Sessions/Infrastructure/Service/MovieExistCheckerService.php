<?php

declare(strict_types=1);

namespace App\Sessions\Infrastructure\Service;

use App\Movies\Domain\Repository\MovieRepositoryInterface;
use App\Sessions\Application\Service\MovieExistCheckerInterface;

class MovieExistCheckerService implements MovieExistCheckerInterface
{
    public function __construct(
        private readonly MovieRepositoryInterface $movieRepository
    ) {
    }

    public function exists(string $movieId): bool
    {
        return $this->movieRepository->get($movieId) !== null;
    }
}