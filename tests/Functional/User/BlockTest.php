<?php

namespace App\Tests\Functional\User;

use App\Entity\User;
use App\Tests\Functional\FunctionalTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class BlockTest extends FunctionalTestCase
{
    private ?int $userId = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->login();
        $this->createTestGuest();
    }

    public function testAdminBlockUser(): void
    {
        $this->login('ina@zaoui.com');
        $this->get('/admin/guests/suspend/'.$this->userId);
        self::assertResponseRedirects('/admin/guests');
        $crawler = $this->client->request('GET', '/admin/guests');
        $rows = $crawler->filter('table tr');
        $row = $rows->reduce(function ($node) {
            return str_contains($node->text(), 'testUserBlock');
        });
        $this->assertCount(1, $row);
        $this->assertStringContainsString("Débloquer l'accès", $row->text());
        $blockUser = $this->getEntityManager()->getRepository(User::class)->find($this->userId);
        $this->assertFalse($blockUser->isActive());
    }

    public function testAdminUnblockUser(): void
    {
        $this->login('ina@zaoui.com');
        $this->get('/admin/guests/unlock/'.$this->userId);
        self::assertResponseRedirects('/admin/guests');
        $crawler = $this->client->request('GET', '/admin/guests');
        $rows = $crawler->filter('table tr');
        $row = $rows->reduce(function ($node) {
            return str_contains($node->text(), 'testUserBlock');
        });
        $this->assertCount(1, $row);
        $this->assertStringContainsString("Bloquer l'accès", $row->text());
        $blockUser = $this->getEntityManager()->getRepository(User::class)->find($this->userId);
        $this->assertTrue($blockUser->isActive());
    }

    public function testUserBlockedLogin(): void
    {
        $this->login('ina@zaoui.com');
        $this->get('/admin/guests/suspend/'.$this->userId);
        self::assertResponseRedirects('/admin/guests');

        $this->get('/logout');
        self::assertResponseRedirects('/');

        $crawler = $this->client->request('GET', '/login');
        $formData = [
            '_username' => 'testuserblock@exemple.com',
            '_password' => 'password',
        ];
        $form = $crawler->selectButton('Connexion')->form($formData);
        $this->client->submit($form);
        $this->client->followRedirect();
        $this->assertSelectorTextSame('.alert-danger', 'Votre compte est suspendu. Contactez un administrateur.');
    }

    public function testUserBlockUser(): void
    {
        $this->get('/admin/guests/suspend/'.$this->userId);
        self::assertResponseStatusCodeSame(403);
    }

    public function testUserUnblockUser(): void
    {
        $this->get('/admin/guests/unlock/'.$this->userId);
        self::assertResponseStatusCodeSame(403);
    }

    public function testGuestBlockUser(): void
    {
        $this->get('/logout');
        self::assertResponseRedirects('/');
        $this->get('/admin/guests/suspend/'.$this->userId);
        self::assertResponseRedirects('/login');
    }

    public function testGuestUnblockUser(): void
    {
        $this->get('/logout');
        self::assertResponseRedirects('/');
        $this->get('/admin/guests/unlock/'.$this->userId);
        self::assertResponseRedirects('/login');
    }

    public function createTestGuest(): void
    {
        $user = new User();
        $user->setId(2);
        $user->setName('testUserBlock');
        $user->setEmail('testuserblock@exemple.com');
        $passwordHasher = $this->service(UserPasswordHasherInterface::class);
        $hashedPassword = $passwordHasher->hashPassword($user, 'password');
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        $this->userId = $user->getId();
    }
}
