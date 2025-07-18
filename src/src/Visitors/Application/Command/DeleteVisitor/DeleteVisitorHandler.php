<?php

declare(strict_types=1);

namespace App\Visitors\Application\Command\DeleteVisitor;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Visitors\Domain\Repository\VisitorRepositoryInterface;

class DeleteVisitorHandler implements CommandHandlerInterface
{
    public function __construct(private readonly VisitorRepositoryInterface $repository)
    {
    }

    public function __invoke(DeleteVisitorCommand $command): void
    {
        $this->repository->delete($command->ulid);
    }
}