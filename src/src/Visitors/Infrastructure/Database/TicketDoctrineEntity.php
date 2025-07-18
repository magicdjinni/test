<?php

declare(strict_types=1);

namespace App\Visitors\Infrastructure\Database;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * индексы хоть они и не особо нужны. но для основных запросов пойдет. поля в порядке селективности
 */
#[ORM\Entity]
#[ORM\Table(name: 'ticket')]
#[ORM\Index(name: "date_moviesession_idx", fields: ["soldDate", "movieSessionUlid"])]
#[ORM\Index(name: "visitor_status_idx", fields: ["visitorUlid", "status"])]
class TicketDoctrineEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $ulid;

    #[ORM\Column(type: 'guid')]
    private string $visitorUlid;

    #[ORM\Column(type: 'guid')]
    private string $movieSessionUlid;

    #[ORM\Column(type: 'string')]
    public string $status;

    #[ORM\Column(type: 'float')]
    private float $soldPrice;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $soldDate;

    public function __construct(
        string $ulid,
        string $visitorUlid,
        string $movieSessionUlid,
        string $status,
        float $soldPrice,
        DateTimeImmutable $soldDate
    ) {
        $this->ulid = $ulid;
        $this->visitorUlid = $visitorUlid;
        $this->movieSessionUlid = $movieSessionUlid;
        $this->status = $status;
        $this->soldPrice = $soldPrice;
        $this->soldDate = $soldDate;
    }

    public function getId(): string
    {
        return $this->ulid;
    }

    public function getVisitorUlid(): string
    {
        return $this->visitorUlid;
    }

    public function getMovieSessionUlid(): string
    {
        return $this->movieSessionUlid;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getSoldPrice(): float
    {
        return $this->soldPrice;
    }

    public function getSoldDate(): DateTimeImmutable
    {
        return $this->soldDate;
    }

    public function setSoldDate(DateTimeImmutable $soldDate): void
    {
        $this->soldDate = $soldDate;
    }
}