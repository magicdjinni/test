<?php

declare(strict_types=1);

namespace App\Movies\Domain\Exceptions;

use DomainException;

final class MovieNotFoundException extends DomainException
{
    public function __construct(string $id)
    {
        parent::__construct("Movie with ID $id not found.");
    }
}