<?php

namespace App\Tests\Visitors\Presentation\Rest\Controller;

use App\Visitors\Application\Command\CancelVisitorTicket\CancelVisitorTicketCommand;
use App\Visitors\Presentation\Rest\Controller\CancelVisitorTicketController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

class CancelVisitorTicketControllerTest extends TestCase
{
    public function testInvokeInvalidJson(): void
    {
        $invalidJson = '{invalid}';
        $request = new Request([], [], [], [], [], [], $invalidJson);

        $commandBusMock = $this->createMock(MessageBusInterface::class);

        $controller = new CancelVisitorTicketController();

        $this->expectException(\JsonException::class);

        $controller->__invoke($request, $commandBusMock);
    }
}