<?php

declare(strict_types=1);

namespace App\Movies\Application\Command\UpdateMovie;

use App\Movies\Domain\Repository\MovieRepositoryInterface;
use App\Movies\Domain\ValueObject\Title;
use App\Shared\Application\Command\CommandHandlerInterface;
use DateTimeImmutable;
use Exception;

class UpdateMovieHandler implements CommandHandlerInterface
{
    public function __construct(private readonly MovieRepositoryInterface $repository)
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(UpdateMovieCommand $command): void
    {
        $entity = $this->repository->get($command->movie->ulid);

        $entity->rename(new Title($command->movie->title));
        $entity->setReleaseDate(new DateTimeImmutable($command->movie->releaseDate));

        $this->repository->update($entity);
    }
}