<?php

namespace App\Tests\Functional\User;

use App\Entity\User;
use App\Tests\Functional\FunctionalTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AddTest extends FunctionalTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->login();
    }

    public function testAdminAddGuest(): void
    {
        $this->login('ina@zaoui.com');
        $this->get('/admin/guest/add');
        $this->assertResponseIsSuccessful();

        $this->submit('Ajouter', self::getFormData());
        self::assertResponseRedirects('/admin/guest');
        $this->client->followRedirect();

        $user = $this->getEntityManager()->getRepository(User::class)->findOneBy(['email' => 'toto@exemple.com']);

        $userPasswordHasher = $this->service(UserPasswordHasherInterface::class);
        self::assertNotNull($user);
        self::assertSame('Toto', $user->getName());
        self::assertSame('toto@exemple.com', $user->getEmail());
        self::assertTrue($userPasswordHasher->isPasswordValid($user, 'TotoPassword123!'));
    }

    public function testUserAddGuest(): void
    {
        $this->get('/admin/guest/add');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testGuestAddGuest(): void
    {
        $this->get('/logout');
        $this->get('/admin/guest/add');
        self::assertResponseRedirects('/login');
    }

    /**
     * @param array<string, string> $overrideData
     *
     * @return array<string, string>
     */
    public static function getFormData(array $overrideData = []): array
    {
        return $overrideData + [
            'user[name]' => 'Toto',
            'user[email]' => 'toto@exemple.com',
            'user[description]' => 'Description Test',
            'user[password]' => 'TotoPassword123!',
            'user[roles]' => 'ROLE_USER',
        ];
    }
}
