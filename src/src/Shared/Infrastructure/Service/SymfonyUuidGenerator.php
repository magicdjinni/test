<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service;

use App\Shared\Domain\Service\UuidGeneratorInterface;
use Symfony\Component\Uid\Ulid;

class SymfonyUuidGenerator implements UuidGeneratorInterface
{
    public static function generate(): string
    {
        return Ulid::generate();
    }
}