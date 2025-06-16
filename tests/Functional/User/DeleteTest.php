<?php

namespace App\Tests\Functional\User;

use App\Entity\User;
use App\Tests\Functional\FunctionalTestCase;

class DeleteTest extends FunctionalTestCase
{
    private ?User $user = null;
    private ?int $userId = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->login();
        $this->createTestGuest();
    }


    public function testAdminDeleteGuest(): void
    {
        $this->login("ina@zaoui.com");
        $this->get("/admin/guests/delete/".$this->userId);
        self::assertResponseRedirects('/admin/guests');
        $this->client->followRedirect();
        self::assertResponseIsSuccessful();
        $deleteUserId = $this->getEntityManager()->getRepository(User::class)->find($this->userId);
        $this->assertNull($deleteUserId);

    }


    public function testUserDeleteGuest(): void
    {
        $this->get("/admin/guests/delete/".$this->userId);
        self::assertResponseStatusCodeSame(403);

    }

    public function testGuestDeleteGuest(): void
    {
        $this->get("/logout");
        $this->get("/admin/guests/delete/".$this->userId);
        self::assertResponseRedirects('/login');

    }

    public function createTestGuest(): void
    {
        $user = new User();
        $user->setId(2);
        $user->setName("testUser");
        $user->setEmail("testuser@exemple.com");
        $user->setPassword("password");
        $user->setRoles(["ROLE_USER"]);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
        $this->user = $user;
        $this->userId = $user->getId();
    }


}
