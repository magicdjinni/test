<?php

declare(strict_types=1);

namespace App\Sessions\Application\Command\UpdateMovieSession;

use App\Sessions\Application\Service\MovieExistCheckerInterface;
use App\Sessions\Domain\Repository\MovieSessionRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use DateTimeImmutable;
use DomainException;
use Exception;

class UpdateMovieSessionHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MovieSessionRepositoryInterface $repository,
        private readonly MovieExistCheckerInterface $movieExistChecker
    ) {
    }

    /**     * @param UpdateMovieSessionCommand $command
     * @return void
     * @throws Exception
     */
    public function __invoke(UpdateMovieSessionCommand $command): void
    {
        // ACL-проверка существования movieId
        if (!$this->movieExistChecker->exists($command->movieSession->movieUlid)) {
            throw new DomainException("Movie with ID {$command->$command->movieSession->movieUlid} does not exist.");
        }

        $entity = $this->repository->get($command->movieSession->ulid);

        $entity->setMovieUlid($command->movieSession->movieUlid);
        $entity->setStartDate(new DateTimeImmutable($command->movieSession->startDate));
        $entity->setPrice($command->movieSession->price);

        $this->repository->update($entity);
    }
}