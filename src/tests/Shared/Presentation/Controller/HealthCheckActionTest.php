<?php

namespace App\Tests\Shared\Presentation\Controller;

use JsonException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class HealthCheckActionTest extends WebTestCase
{
    /**
     * @throws JsonException
     */
    public function test_request_responded_successful_result(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/api/healthcheck');

        self::assertResponseIsSuccessful();
        $jsonResponse = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
        self::assertEquals('OK', $jsonResponse['status']);
    }
}
