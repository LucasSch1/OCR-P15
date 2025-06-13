<?php

namespace App\Tests\Functional;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterTest extends FunctionalTestCase

{
    public function testThatRegistrationShouldSucceeded(): void
    {
        $this->login("ina@zaoui.com");
        $this->get('/admin/guests/add');
        $this->assertResponseIsSuccessful();

        $this->submit('Ajouter', self::getFormData());
        echo $this->client->getResponse()->getContent();
//        $this->assertResponseStatusCodeSame(302);
        $this->client->followRedirect();

        $user = $this->getEntityManager()->getRepository(User::class)->findOneBy(['email'=>'toto@exemple.com']);

        $userPasswordHasher = $this->service(UserPasswordHasherInterface::class);
        self::assertNotNull($user);
        self::assertSame('Toto', $user->getName());
        self::assertSame('toto@exemple.com', $user->getEmail());
        self::assertNotNull($userPasswordHasher->hashPassword($user, $user->getPassword()));

    }


    /**
     * @param array<string, string> $overrideData
     * @return array<string, string>
     */
    public static function getFormData(array $overrideData = []): array
    {
        return $overrideData + [
                'user[name]' => 'Toto',
                'user[email]' => 'toto@exemple.com',
                'user[password]' => 'TotoPassword123!',
                'user[roles]' => 'ROLE_USER',
            ];
    }
}
