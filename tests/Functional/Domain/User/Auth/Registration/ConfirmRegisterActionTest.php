<?php

declare(strict_types=1);

namespace App\Tests\Functional\Domain\User\Auth\Registration;

use App\DataFixtures\User\UserFixtures;
use App\Tests\AbstractTest;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\RawMessage;

class ConfirmRegisterActionTest extends AbstractTest
{
    public function getFixtures() : array
    {
        return [UserFixtures::class];
    }

    public function testValid() : void
    {
        $client = $this->makeRequest('POST', '/auth/register/email', [
            'email' => 'test@test.com',
            'password' => '12345678Ab',
            'plainPassword' => '12345678Ab',
        ], false);

        /** @var Response $response */
        $response = $client->getResponse();

        self::assertResponseOk($response);
        self::assertEmailCount(1);

        /** @var RawMessage $email */
        $email = self::getMailerMessage(0);
        self::assertEmailHeaderSame($email, 'To', 'test@test.com');

        $crawler = new Crawler($email->serialize());
        $code = $crawler->filter('a#confirm-link')->attr('data-token');
        self::assertIsString($code);

        $client = $this->makeRequest('GET', '/auth/register/email/confirm/'.$code);

        /** @var Response $response */
        $response = $client->getResponse();
        $content = new Crawler($response->getContent());
        $link = $content->filter('a[href="/?register=confirm"]');

        self::assertTrue($response->isRedirect());
        self::assertEquals('/?register=confirm', $link->text());
    }


    public function testNonExistingToken() : void
    {
        $client = $this->makeRequest('GET', '/auth/register/email/confirm/123');

        /** @var Response $response */
        $response = $client->getResponse();

        self::assertResponseNotFound($response);
        self::assertEquals('Incorrect or confirmed token.', $response->getContent());
    }
}
