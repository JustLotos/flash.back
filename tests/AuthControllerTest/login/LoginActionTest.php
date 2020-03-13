<?php

declare(strict_types=1);

namespace App\Tests\AuthControllerTest;

use App\DataFixtures\UserFixtures;
use App\Tests\AbstractTest;
use function json_encode;

class LoginActionTest extends AbstractTest
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
        $this->url .= '/v1/auth/login';
    }

    public function testLoginValid() : void
    {
        $client = self::getClient();
        $client->request(
            'POST',
            $this->url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email'=>'ignashov-roman@mail.ru',
                'password' => '123456',
            ])
        );

        $this->assertResponseOk($this->clientAuth->getResponse());
        $this->assertArrayHasKey('token', $this->getRequestContent($this->clientAuth));
        $this->assertArrayHasKey('refresh_token', $this->getRequestContent($this->clientAuth));
        $this->assertArrayHasKey('roles', $this->getRequestContent($this->clientAuth));
    }
}
