<?php

declare(strict_types=1);

namespace App\Visitors\Application\DTO;

use App\Visitors\Domain\Entity\Visitor;

class VisitorDTO
{
    public function __construct(
        public string $ulid,
        public string $email
    ) {
    }

    public static function fromEntity(Visitor $visitor): self
    {
        return new self(
            $visitor->getUlid(),
            $visitor->getEmail()
        );
    }
}