<?php

declare(strict_types=1);

namespace App\Visitors\Application\Command\UpdateVisitor;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Visitors\Domain\Repository\VisitorRepositoryInterface;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UpdateVisitorHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly VisitorRepositoryInterface $repository,
        private readonly UserPasswordHasherInterface $hasher
    )
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(UpdateVisitorCommand $command): void
    {
        $entity = $this->repository->get($command->visitor->ulid);

        $entity->setEmail($command->visitor->email);
        $entity->setPassword($command->password, $this->hasher);

        $this->repository->update($entity);
    }
}