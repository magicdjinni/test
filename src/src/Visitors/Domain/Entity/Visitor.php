<?php

declare(strict_types=1);

namespace App\Visitors\Domain\Entity;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class Visitor implements PasswordAuthenticatedUserInterface
{
    private string $password;

    public function __construct(
        private readonly string $ulid,
        private string $email
    ) {
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getUlid(): string
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

    public function setPassword(string $password, UserPasswordHasherInterface $hasher): void
    {
        $this->password = $hasher->hashPassword($this, $password);
    }

    public function setClearPassword(string $password): void
    {
        $this->password = $password;
    }

}