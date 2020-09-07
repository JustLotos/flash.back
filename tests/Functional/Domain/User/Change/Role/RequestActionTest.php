<?php

declare(strict_types=1);

namespace App\Tests\Functional\Domain\User\Change\Role;

use App\DataFixtures\User\UserFixtures;
use App\Tests\AbstractTest;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mime\RawMessage;

class RequestActionTest extends AbstractTest
{
    protected $method = 'POST';
    protected $uri = '/user/change/role/';

    public function getFixtures() : array
    {
        return [UserFixtures::class];
    }

    public function setUp(): void
    {

    }

    public function testValid(): void
    {
        $this->makeRequestWithAuth([
            'oldEmail' => getenv('TEST_USER_EMAIL'),
            'newEmail' => 'test@test.jest'
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

    public function testNotValidEmails() : void
    {
        $this->makeRequestWithAuth([
            'newEmail' => getenv('TEST_USER_EMAIL'),
            'oldEmail' => 'test@test.jest'
        ]);

        $this->assertResponseCode(JsonResponse::HTTP_NOT_FOUND, $this->response);
        self::assertArrayHasKey('errors', $this->content);
        self::assertArrayHasKey('newEmail', $this->content['errors']);
        self::assertArrayHasKey('oldEmail', $this->content['errors']);
    }
}
