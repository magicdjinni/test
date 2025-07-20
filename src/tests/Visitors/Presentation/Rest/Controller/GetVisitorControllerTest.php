<?php

namespace App\Tests\Visitors\Presentation\Rest\Controller;

use App\Visitors\Application\DTO\VisitorDTO;
use App\Visitors\Application\Query\GetVisitor\GetVisitorQuery;
use App\Visitors\Presentation\Rest\Controller\GetVisitorController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class GetVisitorControllerTest extends WebTestCase
{
    private MessageBusInterface $messageBus;
    private GetVisitorController $controller;

    protected function setUp(): void
    {
        $this->messageBus = $this->createMock(MessageBusInterface::class);
        $this->controller = new GetVisitorController($this->messageBus);
    }

    public function testInvokeReturnsCorrectJsonResponse(): void
    {
        $id = 'sample-ulid';
        $visitorDTO = new VisitorDTO(ulid: $id, email: 'test@example.com');

        $envelope = new Envelope($visitorDTO, [new HandledStamp($visitorDTO, GetVisitorQuery::class)]);
        $this->messageBus->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo(new GetVisitorQuery($id)))
            ->willReturn($envelope);

        $response = $this->controller->__invoke($id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(json_encode([
            'ulid' => $visitorDTO->ulid,
            'title' => $visitorDTO->email,
        ]), $response->getContent());
    }

    public function testInvokeThrowsNotFoundForInvalidVisitor(): void
    {
        $id = 'invalid-ulid';

        $this->messageBus->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo(new GetVisitorQuery($id)))
            ->willThrowException(new NotFoundHttpException());

        $this->expectException(NotFoundHttpException::class);

        $this->controller->__invoke($id);
    }
}