<?php

declare(strict_types=1);

namespace App\Sessions\Domain\Entity;

use DateTimeImmutable;

final class MovieSession
{
    public function __construct(
        private readonly string $ulid,
        private string $movieUlid,
        private DateTimeImmutable $startDate,
        private float $price,
    ) {
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getMovieUlid(): string
    {
        return $this->movieUlid;
    }

    /**
     * @param $movieUlid
     * @return void
     */
    public function setMovieUlid($movieUlid): void
    {
        $this->movieUlid = $movieUlid;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    /**
     * @param DateTimeImmutable $startDate
     */
    public function setStartDate(DateTimeImmutable $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}