<?php

declare(strict_types=1);

namespace App\Tests\UserController;

use App\DataFixtures\UserFixtures;
use App\Tests\AbstractTest;
use Symfony\Component\HttpFoundation\Response;

class GetUserCurrentTest extends AbstractTest
{
    private $clientAuth;

    public function getFixtures() : array
    {
        return [UserFixtures::class];
    }

    public function setUp() : void
    {
        parent::setUp();
        $this->clientAuth = $this->createAuthenticatedClient();
        $this->url .= '/user/current';
    }

    public function testGetUserCurrentValid() : void
    {
        $this->clientAuth->request(
            'GET',
            $this->url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            ''
        );

        /** @var Response $response */
        $response = $this->clientAuth->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertResponseOk($response);
        $this->assertArrayHasKey('email', $content);
        $this->assertArrayHasKey('roles', $content);
        $this->assertArrayHasKey('active', $content);
        $this->assertArrayHasKey('nickname', $content);
    }

}
