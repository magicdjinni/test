<?php

declare(strict_types=1);

namespace App\Visitors\Domain\Exceptions;

use DomainException;

final class VisitorNotFoundException extends DomainException
{
    public function __construct(string $ulid)
    {
        parent::__construct("Visitor with Ulid $ulid not found.");
    }
}