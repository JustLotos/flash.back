<?php

declare(strict_types=1);

namespace App\Tests\Functional\Domain\User\Auth\Login;

use App\DataFixtures\User\UserFixtures;
use App\Tests\AbstractTest;
use Symfony\Component\HttpFoundation\Response;

class RefreshTokenActionTest extends AbstractTest
{
    private $clientAuth;
    private $method = 'POST';
    private $uri = '/auth/token/refresh';

    public function getFixtures() : array
    {
        return [UserFixtures::class];
    }

    public function setUp() : void
    {
        parent::setUp();
        $this->clientAuth = $this->createAuthenticatedClient();
    }

    public function testValid() : void
    {
        /** @var Response $response */
        $response = $this->clientAuth->getResponse();
        $content = json_decode($response->getContent(), true);

        $client = $this->makeRequest($this->method, $this->uri, [
            'refreshToken'=> $content['refreshToken']
        ]);

        /** @var Response $response */
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertResponseOk($response);
        static::assertArrayHasKey('token', $content);
        static::assertArrayHasKey('refreshToken', $content);
    }

    public function testLoginInvalidValue() : void
    {
        $this->makeRequest($this->method, $this->uri, [
            'refreshToken'=> ''
        ]);

        /** @var Response $response */
        $response = $this->clientAuth->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertResponseCode(Response::HTTP_UNPROCESSABLE_ENTITY, $response);
        static::assertArrayHasKey('errors', $content);
        static::assertArrayHasKey('refreshToken', $content['errors']);
    }

    public function testLoginInvalidKey() : void
    {
        /** @var Response $response */
        $response = $this->clientAuth->getResponse();
        $content = json_decode($response->getContent(), true);

        var_dump($content);
        $this->makeRequest($this->method, $this->uri, [
            'refresh'=> $content['refreshToken']
        ]);


        /** @var Response $response */
        $response = $this->clientAuth->getResponse();
        $content = json_decode($response->getContent(), true);

        var_dump($content);

        $this->assertResponseCode(Response::HTTP_UNPROCESSABLE_ENTITY, $response);
        static::assertArrayHasKey('errors', $content);
        static::assertArrayHasKey('refreshToken', $content['errors']);
    }
}
