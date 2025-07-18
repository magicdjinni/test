<?php

declare(strict_types=1);

namespace App\Visitors\Infrastructure\Repository;

use App\Visitors\Domain\Entity\Visitor;
use App\Visitors\Domain\Exceptions\VisitorNotFoundException;
use App\Visitors\Domain\Factory\VisitorFactory;
use App\Visitors\Domain\Repository\VisitorRepositoryInterface;
use App\Visitors\Infrastructure\Database\VisitorDoctrineEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class VisitorRepository implements VisitorRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly VisitorFactory $visitorFactory
    ) {
        $this->repository = $em->getRepository(VisitorDoctrineEntity::class);
    }

    public function add(Visitor $visitor): void
    {
        $doctrineEntity = new VisitorDoctrineEntity(
            $visitor->getUlid(),
            $visitor->getEmail(),
            $visitor->getPassword()
        );

        $this->em->persist($doctrineEntity);
        $this->em->flush();
    }

    public function get(string $ulid): Visitor
    {
        $entity = $this->repository->find($ulid);

        if (!$entity) {
            throw new VisitorNotFoundException($ulid);
        }

        return $this->visitorFactory->map(
            $entity->getId(),
            $entity->getEmail(),
            $entity->getPassword()
        );
    }

    public function findAll(): array
    {
        $entities = $this->repository->findAll();
        $factory = $this->visitorFactory;

        return array_map(static function (VisitorDoctrineEntity $entity) use ($factory) {
            return $factory->map(
                $entity->getId(),
                $entity->getEmail(),
                $entity->getPassword()
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

    public function update(Visitor $visitor): void
    {
        $entity = $this->repository->find($visitor->getUlid());

        if ($entity) {
            $entity->setEmail($visitor->getEmail());
            $entity->setPassword($visitor->getPassword());
        }

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function findOneBy(array $criteria): Visitor
    {
        $entity =  $this->repository->findOneBy($criteria);

        return $this->visitorFactory->map(
            $entity->getId(),
            $entity->getEmail(),
            $entity->getPassword()
        );
    }
}