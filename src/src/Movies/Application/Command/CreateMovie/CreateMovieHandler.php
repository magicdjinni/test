<?php

declare(strict_types=1);

namespace App\Movies\Application\Command\CreateMovie;

use App\Movies\Domain\Entity\Movie;
use App\Movies\Domain\Repository\MovieRepositoryInterface;
use App\Movies\Domain\ValueObject\Title;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Infrastructure\Service\SymfonyUuidGenerator;
use DateTimeImmutable;
use Exception;

final class CreateMovieHandler implements CommandHandlerInterface
{
    public function __construct(private readonly MovieRepositoryInterface $repository)
    {
    }

    /**
     * @param CreateMovieCommand $command
     * @return string
     * @throws Exception
     */
    public function __invoke(CreateMovieCommand $command): string
    {
        /**
         * тут с фабрикой не заморачивался. пример есть в visitors
         */
        $movie = new Movie(
            ulid: SymfonyUuidGenerator::generate(),
            title: new Title($command->title),
            releaseDate: new DateTimeImmutable($command->releaseDate)
        );

        $this->repository->save($movie);

        return $movie->getUlid();
    }
}