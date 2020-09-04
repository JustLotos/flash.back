<?php

declare(strict_types=1);

namespace App\Tests\AuthController\PasswordReset;

use App\DataFixtures\UserFixtures;
use App\Tests\AbstractTest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordConfirmActionTest extends AbstractTest
{
    public function getFixtures() : array
    {
        return [UserFixtures::class];
    }

    public function setUp() : void
    {
        parent::setUp();
        $this->url .= '/auth/password/reset/confirm';
    }

    public function testResetPasswordConfirmValidKey()
    {
        $client = self::getClient();
        $client->request(
            'POST',
            $this->url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'test' => 'test'
            ])
        );

        /** @var Response $response */
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);
        $this->assertResponseCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, $response);
        $this->assertArrayHasKey('errors', $content);
        $this->assertArrayHasKey('email', $content['errors']);
        $this->assertArrayHasKey('password', $content['errors']);
        $this->assertArrayHasKey('plain_password', $content['errors']);
        $this->assertArrayHasKey('confirmation_code', $content['errors']);
    }

    public function testResetPasswordConfirmValidValue()
    {
        $client = self::getClient();
        $client->request(
            'POST',
            $this->url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test',
                'password' => '123',
                'plain_password' => '111',
                'confirmation_code' => '123'
            ])
        );

        /** @var Response $response */
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);
        $this->assertResponseCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, $response);
        $this->assertArrayHasKey('errors', $content);
        $this->assertArrayHasKey('email', $content['errors']);
        $this->assertArrayHasKey('password', $content['errors']);
        $this->assertArrayHasKey('plain_password', $content['errors']);
    }
}
