<?php

declare(strict_types=1);

namespace App\Tests\AuthController\Registration;

use App\DataFixtures\UserFixtures;
use App\Tests\AbstractTest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function json_encode;
use function var_dump;

class RegisterActionTest extends AbstractTest
{
    public function getFixtures() : array
    {
        return [UserFixtures::class];
    }

    public function setUp() : void
    {
        parent::setUp();
        $this->url .= '/auth/register';
    }

    public function testRegisterValid() : void
    {
        $client = self::getClient();
        $client->request(
            'POST',
            $this->url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test@mail.ru',
                'password' => '12345678',
                'plain_password' => '12345678',
            ])
        );

        /** @var Response $response */
        $response = $client->getResponse();

        $content = json_decode($response->getContent(), true);

        $this->assertResponseOk($response);
        $this->assertArrayHasKey('token', $content);
        $this->assertArrayHasKey('refresh_token', $content);
        $this->assertArrayHasKey('roles', $content);
    }

    /**
     * тестирование валидации данных
     */
    public function testRegisterInvalidValue() : void
    {
        $client = self::getClient();
        $client->request(
            'POST',
            $this->url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email'=>'invalid_email',
                'password' => '-',
                'plain_password' => '+',
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

    /**
     * тестирование валидации данных
     */
    public function testRegisterInvalidKey() : void
    {
        $client = self::getClient();
        $client->request(
            'POST',
            $this->url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username'=>'',
                'word' => '',
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

    /**
     * тестирование ункиальности email'a пользователя
     */
    public function testRegisterUnique() : void
    {
        $client = self::getClient();
        $client->request(
            'POST',
            $this->url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email'=>'ignashov-roman@maril.ru',
                'password' => '12345678',
                'plain_password' => '12345678'
            ])
        );
        $client->getResponse();

        $client->request(
            'POST',
            $this->url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email'=>'ignashov-roman@maril.ru',
                'password' => '12345678',
                'plain_password' => '12345678',
            ])
        );

        /** @var Response $response */
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertResponseCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, $response);
        $this->assertArrayHasKey('errors', $content);
        $this->assertArrayHasKey('email', $content['errors']);
    }

    /**
     * Проверка регистрации при наличии токена
     */
    public function testAuthRegister() : void
    {
        $clientAuth = $this->createAuthenticatedClient();
        $clientAuth->request(
            'POST',
            $this->url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email'=>'test@mail.ru',
                'password' => '1234567',
            ])
        );
        /** @var Response $response */
        $response = $clientAuth->getResponse();
        $content = json_decode($response->getContent(), true);
        $this->assertResponseCode(JsonResponse::HTTP_UNAUTHORIZED, $response);
        $this->assertArrayHasKey('errors', $content);
        $this->assertArrayHasKey('register', $content['errors']);
    }
}
