<?php

declare(strict_types=1);

namespace App\Tests\AuthController\Registration;

use App\DataFixtures\UserFixtures;
use App\Tests\AbstractTest;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function json_encode;

class RegisterConfirmActionTest extends AbstractTest
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

    /*
     * Сначало регистрируемя для того чтобы проверить отправку письма
     *  - получаем код и вводим его
     */
    public function testRegisterConfirmValid() : void
    {
        /* Регистрация */
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
        $this->assertResponseOk($response);
        $this->assertEmailCount(1);

        $email = $this->getMailerMessage(0);
        $crawler = new Crawler($email->getHtmlBody());
        $code = $crawler->filter('#registerCode');
        $this->assertIsString($code->text());

        /* Непосредственно проверка подтверждения */
        $client->request(
            'POST',
            $this->url.'/confirm',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test@mail.ru',
                'confirmation_code' => $code->text()
            ])
        );

        /** @var Response $response */
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);
        $this->assertResponseOk($response);
        $this->assertArrayHasKey('success', $content);
    }


    public function testRegisterConfirmInvalidKey() : void
    {
        $client = self::getClient();
        $client->request(
            'POST',
            $this->url.'/confirm',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'mail' => 'test@mail.ru',
                'code' => 'invalid code'
            ])
        );

        /** @var Response $response */
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertResponseCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, $response);
        $this->assertArrayHasKey('errors', $content);
        $this->assertArrayHasKey('email', $content['errors']);
        $this->assertArrayHasKey('confirmation_code', $content['errors']);
    }

    public function testRegisterConfirmInvalidValue() : void
    {
        $client = self::getClient();
        $client->request(
            'POST',
            $this->url.'/confirm',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'test123@mail.ru',
            ])
        );

        /** @var Response $response */
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);
        $this->assertResponseCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, $response);
        $this->assertArrayHasKey('errors', $content);
        $this->assertArrayHasKey('email', $content['errors']);

        $client = self::getClient();
        $client->request(
            'POST',
            $this->url.'/confirm',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => self::USER_EMAIL,
                'confirmation_code' => 'text'
            ])
        );

        /** @var Response $response */
        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertResponseCode(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, $response);
        $this->assertArrayHasKey('errors', $content);
        $this->assertArrayHasKey('confirmation_code', $content['errors']);
    }
}
