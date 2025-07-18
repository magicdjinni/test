<?php

declare(strict_types=1);

namespace App\Sessions\Application\Command\DeleteMovieSession;

use App\Sessions\Domain\Repository\MovieSessionRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

class DeleteMovieSessionHandler implements CommandHandlerInterface
{
    public function __construct(private readonly MovieSessionRepositoryInterface $repository)
    {
    }

    public function __invoke(DeleteMovieSessionCommand $command): void
    {
        $this->repository->delete($command->ulid);
    }
}