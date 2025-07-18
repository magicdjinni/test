<?php

declare(strict_types=1);

namespace App\Movies\Application\Command\DeleteMovie;

use App\Movies\Domain\Repository\MovieRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

class DeleteMovieHandler implements CommandHandlerInterface
{
    public function __construct(private readonly MovieRepositoryInterface $repository)
    {
    }

    public function __invoke(DeleteMovieCommand $command): void
    {
        $this->repository->delete($command->ulid);
    }
}