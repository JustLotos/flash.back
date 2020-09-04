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

    public function testValid() : void
    {
        $this->clientAuth = $this->createAuthenticatedClient();
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

    public function testInvalidValue() : void
    {
        $client = $this->makeRequest($this->method, $this->uri, [
            'refreshToken'=> '123123'
        ], false);

        /** @var Response $response */
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertResponseCode(Response::HTTP_UNAUTHORIZED, $response);
        static::assertArrayHasKey('errors', $content);
        static::assertArrayHasKey('auth', $content['errors']);
    }
}
