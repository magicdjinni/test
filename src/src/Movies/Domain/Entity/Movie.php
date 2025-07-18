<?php

declare(strict_types=1);

namespace App\Movies\Domain\Entity;

use App\Movies\Domain\ValueObject\Title;
use DateTimeImmutable;

final class Movie
{
    public function __construct(
        private readonly string $ulid,
        private Title $title,
        private DateTimeImmutable $releaseDate,
    ) {
    }

    public function rename(Title $newTitle): void
    {
        $this->title = $newTitle;
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getReleaseDate(): DateTimeImmutable
    {
        return $this->releaseDate;
    }

    /**
     * @param DateTimeImmutable $releaseDate
     */
    public function setReleaseDate(DateTimeImmutable $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }
}