<?php


namespace App\Tests\AuthControllerTest;

use App\DataFixtures\UserFixtures;
use App\Tests\AbstractTest;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterActionTest extends AbstractTest
{
    public function getFixtures(): array
    {
        return [
            UserFixtures::class
        ];
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->url .= '/v1/register';
    }

    /**
     * тестирование запроса
     */
    public function testRegisterValid(): void
    {
        $client = self::getClient();
        $client->request(
            'POST',
            $this->url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email'=>'test@mail.ru',
                'password' => '12345678',
                'roles' => []
            ])
        );

        $content = $this->getRequestContent($client);

        $this->assertResponseOk($client->getResponse());
        $this->assertArrayHasKey('token', $content);
        $this->assertArrayHasKey('refresh_token', $content);
        $this->assertArrayHasKey('roles', $content);
    }

    /**
     * тестирование валидации данных
     */
    public function testRegisterInvalid(): void
    {
        // Тестирование значений
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
                'roles' => []
            ])
        );
        var_dump($this->url);
        $content = $this->getRequestContent($client);

        $this->assertResponseCode(
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            $client->getResponse()
        );
        $this->assertArrayHasKey('errors', $content);
        $this->assertArrayHasKey('email', $content['errors']);
        $this->assertArrayHasKey('password', $content['errors']);

        // Тестирование полей
        $client->request(
            'POST',
            $this->url,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username'=>'',
                'word' => ''
            ])
        );

        $content = $this->getRequestContent($client);
        $this->assertResponseCode(
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            $client->getResponse()
        );
        $this->assertArrayHasKey('errors', $content);
        $this->assertArrayHasKey('email', $content['errors']);
        $this->assertArrayHasKey('password', $content['errors']);
    }

    /**
     * тестирование ункиальности email'a пользователя
     */
    public function testRegisterUnique(): void
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
                'password' => '123456',
            ])
        );
        $client->request(
            'POST',
            'http://billing.study-on.local:82/api/v1/register',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email'=>'ignashov-roman@maril.ru',
                'password' => '123456',
            ])
        );
        $content = $this->getRequestContent($client);
        $this->assertResponseCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, $client->getResponse());
        $this->assertArrayHasKey('errors', $content);
        $this->assertArrayHasKey('email', $content['errors']);
    }

    /**
     * Проверка регистрации при наличии активной авторизации
     */
    public function testAuthRegister(): void
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

        $content = $this->getRequestContent($clientAuth);
        $this->assertResponseCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, $clientAuth->getResponse());
        $this->assertArrayHasKey('errors', $content);
        $this->assertArrayHasKey('auth', $content['errors']);
    }
}