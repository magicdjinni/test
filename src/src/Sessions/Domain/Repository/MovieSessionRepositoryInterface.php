<?php

declare(strict_types=1);

namespace App\Sessions\Domain\Repository;

use App\Sessions\Domain\Entity\MovieSession;

interface MovieSessionRepositoryInterface
{
    public function save(MovieSession $movieSession): void;

    public function get(string $ulid): MovieSession;

    public function update(MovieSession $movieSession): void;

    /** @return MovieSession[] */
    public function findAll(): array;

    public function delete(string $ulid): void;
}