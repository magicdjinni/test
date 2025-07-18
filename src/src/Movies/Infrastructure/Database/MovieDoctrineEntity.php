<?php

declare(strict_types=1);

namespace App\Movies\Infrastructure\Database;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'movies')]
class MovieDoctrineEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $ulid;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $releaseDate;

    public function __construct(string $ulid, string $title, DateTimeImmutable $releaseDate)
    {
        $this->ulid = $ulid;
        $this->title = $title;
        $this->releaseDate = $releaseDate;
    }

    public function getId(): string
    {
        return $this->ulid;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getReleaseDate(): DateTimeImmutable
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(DateTimeImmutable $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }
}