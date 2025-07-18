<?php

declare(strict_types=1);

namespace App\Movies\Infrastructure\Repository;

use App\Movies\Domain\Entity\Movie;
use App\Movies\Domain\Exceptions\MovieNotFoundException;
use App\Movies\Domain\Repository\MovieRepositoryInterface;
use App\Movies\Domain\ValueObject\Title;
use App\Movies\Infrastructure\Database\MovieDoctrineEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class MovieRepository implements MovieRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(private EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(MovieDoctrineEntity::class);
    }

    public function save(Movie $movie): void
    {
        $doctrineEntity = new MovieDoctrineEntity(
            $movie->getUlid(),
            $movie->getTitle()->value(),
            $movie->getReleaseDate()
        );

        $this->em->persist($doctrineEntity);
        $this->em->flush();
    }

    public function get(string $ulid): Movie
    {
        $entity = $this->repository->find($ulid);

        if (!$entity) {
            throw new MovieNotFoundException($ulid);
        }

        return new Movie(
            $entity->getId(),
            new Title($entity->getTitle()),
            $entity->getReleaseDate()
        );
    }

    public function findAll(): array
    {
        $entities = $this->repository->findAll();

        return array_map(static function (MovieDoctrineEntity $entity) {
            return new Movie(
                $entity->getId(),
                new Title($entity->getTitle()),
                $entity->getReleaseDate()
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

    public function update(Movie $movie): void
    {
        $entity = $this->repository->find($movie->getUlid());

        if ($entity) {
            $entity->setTitle($movie->getTitle()->value());
            $entity->setReleaseDate($movie->getReleaseDate());
        }

        $this->em->persist($entity);
        $this->em->flush();
    }
}