<?php

declare(strict_types=1);

namespace App\Visitors\Application\Command\CreateVisitor;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Visitors\Domain\Factory\VisitorFactory;
use App\Visitors\Domain\Repository\VisitorRepositoryInterface;

class CreateVisitorHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly VisitorRepositoryInterface $repository,
        private readonly VisitorFactory $factory
    )
    {
    }

    public function __invoke(CreateVisitorCommand $command): string
    {

        $visitor = $this->factory->create(
            $command->email,
            $command->password
        );

        $this->repository->add($visitor);

        return $visitor->getUlid();
    }
}