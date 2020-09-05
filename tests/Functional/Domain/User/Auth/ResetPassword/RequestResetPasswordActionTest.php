<?php

declare(strict_types=1);

namespace App\Tests\Functional\Domain\User\Auth\ResetPassword;

use App\DataFixtures\User\UserFixtures;
use App\Tests\AbstractTest;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mime\RawMessage;

class RequestResetPasswordActionTest extends AbstractTest
{
    protected $method = 'POST';
    protected $uri = '/auth/reset/password';

    public function getFixtures() : array
    {
        return [UserFixtures::class];
    }

    public function testValid(): void
    {
        $this->makeRequest([
            'email' => getenv('TEST_USER_EMAIL'),
            'password' => '12345678Ab',
            'plainPassword' => '12345678Ab'
        ]);

        self::assertResponseOk($this->response);
        self::assertEmailCount(1);
        self::assertArrayHasKey('success', $this->content);

        /** @var RawMessage $email */
        $email = self::getMailerMessage(0);

        $crawler = new Crawler($email->serialize());
        $code = $crawler->filter('a.confirm-link')->attr('data-token');
        self::assertIsString($code);
    }

    public function testNotExistingEmail() : void
    {
        $this->makeRequest([
            'email' => 'not@found.email',
            'password' => '12345678Ab',
            'plainPassword' => '12345678Ab'
        ]);

        $this->assertResponseCode(JsonResponse::HTTP_NOT_FOUND, $this->response);
        self::assertArrayHasKey('errors', $this->content);
        self::assertArrayHasKey('email', $this->content['errors']);
    }
}
