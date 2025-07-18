<?php

declare(strict_types=1);

namespace App\Visitors\Infrastructure\Database;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'visitor')]
class VisitorDoctrineEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $ulid;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    public function __construct(string $ulid, string $email, string $password)
    {
        $this->ulid = $ulid;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): string
    {
        return $this->ulid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}