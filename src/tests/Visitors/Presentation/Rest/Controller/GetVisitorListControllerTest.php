<?php

namespace App\Tests\Visitors\Presentation\Rest\Controller;

use App\Visitors\Application\Query\GetVisitorList\GetVisitorListQuery;
use App\Visitors\Presentation\Rest\Controller\GetVisitorListController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class GetVisitorListControllerTest extends TestCase
{
    public function testInvokeReturnsVisitorsList()
    {
        // Mock the expected visitor list
        $expectedVisitors = [
            ['id' => 1, 'name' => 'John Doe'],
            ['id' => 2, 'name' => 'Jane Smith'],
        ];

        // Create a mock for the MessageBusInterface
        $messageBusMock = $this->createMock(MessageBusInterface::class);
        $messageBusMock->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(GetVisitorListQuery::class))
            ->willReturn(new Envelope(new \stdClass(), [new HandledStamp($expectedVisitors, 'handler.service.id')]));

        // Instantiate the controller with the mock MessageBus
        $controller = new GetVisitorListController($messageBusMock);

        // Call the __invoke method and test the response
        $response = $controller->__invoke();

        $this->assertInstanceOf(JsonResponse::class, $response, 'Response must be an instance of JsonResponse');
        $this->assertSame(200, $response->getStatusCode(), 'Response status code must be 200');
        $this->assertSame(
            $expectedVisitors,
            json_decode($response->getContent(), true),
            'Response content must match the expected visitor list'
        );
    }
}