<?php

declare(strict_types=1);

namespace App\Sessions\Infrastructure\Database;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'moviesession')]
class MovieSessionDoctrineEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $ulid;

    #[ORM\Column(type: 'guid')]
    private string $movieUlid;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $startDate;

    #[ORM\Column(type: 'float')]
    private float $price;

    public function __construct(string $ulid, string $movieUlid, DateTimeImmutable $startDate, float $price)
    {
        $this->ulid = $ulid;
        $this->movieUlid = $movieUlid;
        $this->startDate = $startDate;
        $this->price = $price;
    }

    public function getId(): string
    {
        return $this->ulid;
    }

    public function getMovieUlid(): string
    {
        return $this->movieUlid;
    }

    public function setMovieUlid(string $movieUlid): void
    {
        $this->movieUlid = $movieUlid;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

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