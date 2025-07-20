<?php

namespace App\Tests\Shared\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomePageActionTest extends WebTestCase
{
    /**
     * Tests that the index method returns a successful response with status 200.
     */
    public function testIndexReturnsSuccessResponse(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}