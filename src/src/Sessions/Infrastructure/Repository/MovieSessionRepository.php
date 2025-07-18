<?php

declare(strict_types=1);

namespace App\Sessions\Infrastructure\Repository;

use App\Sessions\Domain\Entity\MovieSession;
use App\Sessions\Domain\Exceptions\MovieSessionNotFoundException;
use App\Sessions\Domain\Repository\MovieSessionRepositoryInterface;
use App\Sessions\Infrastructure\Database\MovieSessionDoctrineEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class MovieSessionRepository implements MovieSessionRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(private readonly EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(MovieSessionDoctrineEntity::class);
    }

    public function save(MovieSession $movieSession): void
    {
        $doctrineEntity = new MovieSessionDoctrineEntity(
            $movieSession->getUlid(),
            $movieSession->getMovieUlid(),
            $movieSession->getStartDate(),
            $movieSession->getPrice()
        );

        $this->em->persist($doctrineEntity);
        $this->em->flush();
    }

    public function get(string $ulid): MovieSession
    {
        $entity = $this->repository->find($ulid);

        if (!$entity) {
            throw new MovieSessionNotFoundException($ulid);
        }

        return new MovieSession(
            $entity->getId(),
            $entity->getMovieUlid(),
            $entity->getStartDate(),
            $entity->getPrice()
        );
    }

    public function findAll(): array
    {
        $entities = $this->repository->findAll();

        return array_map(static function (MovieSessionDoctrineEntity $entity) {
            return new MovieSession(
                $entity->getId(),
                $entity->getMovieUlid(),
                $entity->getStartDate(),
                $entity->getPrice()
            );
        }, $entities);
    }

    public function delete(string $ulid): void
    {
        $entity = $this->repository->find($ulid);

        if ($entity) {
            $this->em->remove($entity);
            $this->em->flush();
        }
    }

    public function update(MovieSession $movieSession): void
    {
        $entity = $this->repository->find($movieSession->getUlid());

        if ($entity) {
            $entity->setMovieUlid($movieSession->getMovieUlid());
            $entity->setStartDate($movieSession->getStartDate());
            $entity->setPrice($movieSession->getPrice());
        }

        $this->em->persist($entity);
        $this->em->flush();
    }
}