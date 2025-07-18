<?php

declare(strict_types=1);

namespace App\Sessions\Domain\Exceptions;

use DomainException;

final class MovieSessionNotFoundException extends DomainException
{
    public function __construct(string $id)
    {
        parent::__construct("Movie session with ID $id not found.");
    }
}