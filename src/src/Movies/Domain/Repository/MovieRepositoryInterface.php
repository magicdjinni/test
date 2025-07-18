<?php

declare(strict_types=1);

namespace App\Movies\Domain\Repository;

use App\Movies\Domain\Entity\Movie;

interface MovieRepositoryInterface
{
    public function save(Movie $movie): void;

    public function get(string $ulid): Movie;

    public function update(Movie $movie): void;

    /** @return Movie[] */
    public function findAll(): array;

    public function delete(string $ulid): void;
}