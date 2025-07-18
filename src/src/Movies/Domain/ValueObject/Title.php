<?php

declare(strict_types=1);

namespace App\Movies\Domain\ValueObject;

use InvalidArgumentException;

final class Title
{
    public function __construct(private readonly string $value)
    {
        $this->assertValid($value);
    }

    private function assertValid(string $value): void
    {
        if (mb_strlen($value) < 2) {
            throw new InvalidArgumentException('Title must be at least 2 characters long.');
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}