<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user1 = new User();
        $user1->setAdmin(true);
        $user1->setName('Ina Zaoui');
        $user1->setEmail('ina@zaoui.com');
        $user1->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword($user1, 'password');
        $user1->setPassword($hashedPassword);
        $manager->persist($user1);

        for ($i = 0; $i <= 99; ++$i) {
            $user = new User();
            $user->setAdmin(false);
            $user->setName('Invité'.$i);
            $user->setEmail('invite+'.$i.'@exemple.com');
            $hashedPassword = $this->passwordHasher->hashPassword($user1, 'password');
            $user->setPassword($hashedPassword);
            $user->setDescription("Le maître de l''urbanité capturée, explore les méandres des cités avec un regard vif et impétueux, figeant l''énergie des rues dans des instants éblouissants. À travers une technique avant-gardiste, il métamorphose le béton et l''acier en toiles abstraites, ");
            $manager->persist($user);
        }

        $manager->flush();
    }
}
