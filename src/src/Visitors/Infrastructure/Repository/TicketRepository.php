<?php

declare(strict_types=1);

namespace App\Visitors\Infrastructure\Repository;

use App\Visitors\Domain\Entity\Ticket;
use App\Visitors\Domain\Repository\TicketRepositoryInterface;
use App\Visitors\Infrastructure\Database\TicketDoctrineEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class TicketRepository implements TicketRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(private readonly EntityManagerInterface $em
    ) {
        $this->repository = $em->getRepository(TicketDoctrineEntity::class);
    }

    public function add(Ticket $ticket): void
    {
        $doctrineEntity = new TicketDoctrineEntity(
            $ticket->getUlid(),
            $ticket->getVisitorUlid(),
            $ticket->getMovieSessionUlid(),
            $ticket->getStatus(),
            $ticket->getSoldPrice(),
            $ticket->getSoldDate()
        );

        $this->em->persist($doctrineEntity);
        $this->em->flush();
    }

    public function cancel(string $ulid): void
    {
        $entity = $this->repository->find($ulid);

        if ($entity) {
            $entity->setStatus('cancelled');
        }

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function findAll(): array
    {
        $entities = $this->repository->findAll();

        return array_map(static function (TicketDoctrineEntity $entity) {
            return new Ticket(
                $entity->getId(),
                $entity->getVisitorUlid(),
                $entity->getMovieSessionUlid(),
                $entity->getStatus(),
                $entity->getSoldPrice(),
                $entity->getSoldDate()
            );
        }, $entities);
    }

    public function findBy(array $criteria): array
    {
        $entities =  $this->repository->findBy($criteria);

        return array_map(static function (TicketDoctrineEntity $entity) {
            return new Ticket(
                $entity->getId(),
                $entity->getVisitorUlid(),
                $entity->getMovieSessionUlid(),
                $entity->getStatus(),
                $entity->getSoldPrice(),
                $entity->getSoldDate()
            );
        }, $entities);

    }
}