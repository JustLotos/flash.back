<?php

declare(strict_types=1);

namespace App\Tests\Functional\Domain\User\Auth\Registration;

use App\DataFixtures\User\UserFixtures;
use App\Tests\AbstractTest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisterByEmailActionTest extends AbstractTest
{
    private $email =  'email@email.eamil';
    private $password = '12345678Ab';

    public function getFixtures() : array
    {
        return [UserFixtures::class];
    }

    public function testRegisterValid() : void
    {
        $client = $this->makeRequest('POST', '/auth/register/email', [
            'email' => $this->email,
            'password' => $this->password,
            'plainPassword' => $this->password
        ], false);

        /** @var Response $response */
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        self::assertResponseOk($response);
        self::assertArrayHasKey('token', $content);
        self::assertArrayHasKey('status', $content);
        self::assertArrayHasKey('refreshToken', $content);
        self::assertArrayHasKey('role', $content);
        self::assertArrayHasKey('email', $content);
        self::assertEquals($this->email, $content['email']);
        self::assertEquals('WAIT', $content['status']);
    }

    /**
     * @dataProvider getInvalidCredential
     */
    public function testInvalidValue(string $password) : void
    {
        $client = $this->makeRequest('POST', '/auth/register/email', [
            'email' => $password ? $password : '',
            'password' => $password,
            'plainPassword' => ''
        ], false);

        /** @var Response $response */
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        self::assertResponseCode(JsonResponse::HTTP_NOT_FOUND, $response);
        self::assertArrayHasKey('errors', $content);
        self::assertArrayHasKey('email', $content['errors']);
        self::assertArrayHasKey('password', $content['errors']);
        self::assertArrayHasKey('plainPassword', $content['errors']);
    }

    public function getInvalidCredential()
    {
        return [ [''], ['123'], ['Ab1'], ['freshManF'], ['12345678A'] ];
    }

    /**
     * тестирование ункиальности email'a пользователя
     */
    public function testRegisterUnique() : void
    {
        $client = $this->makeRequest('POST', '/auth/register/email', [
            'email' => getenv('TEST_USER_EMAIL'),
            'password' => '12345678Ab',
            'plainPassword' => '12345678Ab'
        ], false);

        /** @var Response $response */
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        self::assertResponseCode(JsonResponse::HTTP_NOT_FOUND, $response);
        self::assertArrayHasKey('errors', $content);
        self::assertArrayHasKey('email', $content['errors']);
    }
}
