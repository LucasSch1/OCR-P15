<?php

namespace App\Tests\Functional\Front;

use App\Entity\Album;
use App\Entity\Media;
use App\Entity\User;
use App\Tests\Functional\FunctionalTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class FrontTest extends FunctionalTestCase
{
    private ?int $userId = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createTestUser();
        $this->createAlbum();
    }

    public function testShowGuestsPage(): void
    {
        $this->get('/guests');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h3', 'Invités');
        self::assertSelectorExists('.guests');
        $crawler = $this->client->request('GET', '/guests');
        $crawler->filter('.guest')->reduce(function ($node) {
            return str_contains($node->text(), 'Toto');
        });
        $this->assertCount(1, $crawler);
        $this->assertStringContainsString('Toto', $crawler->text());
    }

    public function testShowGuestPage(): void
    {
        $this->get('/guest/'.$this->userId);
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h3', 'Toto');
        self::assertSelectorTextContains('p', 'Ceci est un test');
        $crawler = $this->client->request('GET', '/guest/'.$this->userId);
        $rows = $crawler->filter('.col-4.media');
        $this->assertCount(1, $rows);
    }

    public function testShowPortfolioPage(): void
    {
        $this->get('/portfolio');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h3', 'Portfolio');
        $this->assertSelectorCount(7, '.col-2');
    }

    public function testShowAboutPage(): void
    {
        $this->get('/about');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h2', 'Qui suis-je ?');
        self::assertSelectorExists('p');
        self::assertSelectorExists('.col-4 img');
    }

    public function createTestUser(): User
    {
        $user = new User();
        $user->setName('Toto');
        $user->setEmail('toto@exemple.com');
        $user->setDescription('Ceci est un test');
        $user->setRoles(['ROLE_USER']);
        $user->setIsActive(true);

        $media = new Media();
        $media->setTitle('Test title');
        $media->setPath('tests/Functional/Media/fixtures/test_media.jpg');
        $media->setUser($user);

        $passwordHasher = $this->service(UserPasswordHasherInterface::class);
        $hashedPassword = $passwordHasher->hashPassword($user, 'TotoPassword123!');
        $user->setPassword($hashedPassword);

        $em = $this->getEntityManager();
        $em->persist($user);
        $em->persist($media);
        $em->flush();
        $this->userId = $user->getId();

        return $user;
    }

    public function createAlbum(): Album
    {
        $album = new Album();
        $album->setName('Test Album');

        $em = $this->getEntityManager();
        $em->persist($album);
        $em->flush();

        return $album;
    }
}
