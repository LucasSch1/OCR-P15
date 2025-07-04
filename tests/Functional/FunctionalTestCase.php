<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

abstract class FunctionalTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->service(EntityManagerInterface::class);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $id
     *
     * @return T
     */
    protected function service(string $id): object
    {
        return $this->client->getContainer()->get($id);
    }

    /**
     * @param array<string, mixed> $parameters
     */
    protected function get(string $uri, array $parameters = []): Crawler
    {
        return $this->client->request('GET', $uri, $parameters);
    }

    protected function login(string $email = 'invite+1@exemple.com'): void
    {
        $user = $this->service(EntityManagerInterface::class)->getRepository(User::class)->findOneBy(['email' => $email]);

        $this->client->loginUser($user);
    }

    /**
     * @param array<string, mixed> $formData
     */
    protected function submit(string $button, array $formData = [], string $method = 'POST'): Crawler
    {
        return $this->client->submitForm($button, $formData, $method);
    }
}
