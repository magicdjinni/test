<?php

declare(strict_types=1);

namespace App\Visitors\Domain\Factory;

use App\Shared\Infrastructure\Service\SymfonyUuidGenerator;
use App\Visitors\Domain\Entity\Visitor;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class VisitorFactory
{
    /**
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(private readonly UserPasswordHasherInterface $hasher)
    {
    }

    /**
     * @param string $email
     * @param string $password
     * @return Visitor
     */
    public function create(string $email, string $password): Visitor
    {
        $visitor = new Visitor(
            SymfonyUuidGenerator::generate(),
            $email
        );
        $visitor->setPassword($password, $this->hasher);

        return $visitor;
    }

    /**
     * @param string $ulid
     * @param string $email
     * @param string $password
     * @return Visitor
     */
    public function map(string $ulid, string $email, string $password): Visitor
    {
        $visitor = new Visitor($ulid, $email);
        $visitor->setClearPassword($password);

        return $visitor;
    }
}