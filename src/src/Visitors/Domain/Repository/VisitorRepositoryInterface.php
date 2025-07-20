<?php

declare(strict_types=1);

namespace App\Visitors\Domain\Repository;

use App\Visitors\Domain\Entity\Visitor;

interface VisitorRepositoryInterface
{
    public function add(Visitor $visitor): void;

    public function get(string $ulid): Visitor;

    public function update(Visitor $visitor): void;

    public function delete(string $ulid): void;

    /** @return Visitor[] */
    public function findAll(): array;

    public function findOneBy(array $criteria): ?Visitor;
}