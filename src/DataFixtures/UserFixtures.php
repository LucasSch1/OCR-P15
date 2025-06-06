<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user1 = new User();
        $user1->setAdmin(true);
        $user1->setName('Ina Zaoui');
        $user1->setEmail('ina@zaoui.com');
        $manager->persist($user1);

        for($i=0;$i<=99;$i++){
            $user= new User();
            $user->setAdmin(false);
            $user->setName('Invité'.$i);
            $user->setEmail('invite+'.$i.'@exemple.com');
            $user->setDescription("Le maître de l''urbanité capturée, explore les méandres des cités avec un regard vif et impétueux, figeant l''énergie des rues dans des instants éblouissants. À travers une technique avant-gardiste, il métamorphose le béton et l''acier en toiles abstraites, ");
            $manager->persist($user);
        }


        $manager->flush();
    }
}
