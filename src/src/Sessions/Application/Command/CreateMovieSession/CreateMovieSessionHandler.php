<?php

declare(strict_types=1);

namespace App\Sessions\Application\Command\CreateMovieSession;

use App\Sessions\Application\Service\MovieExistCheckerInterface;
use App\Sessions\Domain\Entity\MovieSession;
use App\Sessions\Domain\Repository\MovieSessionRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Infrastructure\Service\SymfonyUuidGenerator;
use DateTimeImmutable;
use DomainException;
use Exception;

final class CreateMovieSessionHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MovieSessionRepositoryInterface $repository,
        private readonly MovieExistCheckerInterface $movieExistChecker
    ) {
    }

    /**
     * @param CreateMovieSessionCommand $command
     * @return string
     * @throws Exception
     */
    public function __invoke(CreateMovieSessionCommand $command): string
    {
        // ACL-проверка существования movieId
        if (!$this->movieExistChecker->exists($command->movieUlid)) {
            throw new DomainException("Movie with ID {$command->movieUlid} does not exist.");
        }

        $movieSession = new MovieSession(
            ulid: SymfonyUuidGenerator::generate(),
            movieUlid: $command->movieUlid,
            startDate: new DateTimeImmutable($command->startDate),
            price: $command->price,
        );

        $this->repository->save($movieSession);

        return $movieSession->getUlid();
    }
}