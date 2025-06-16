<?php

namespace App\Tests\Unitary;

use App\Entity\Media;
use App\Entity\User;
use App\Security\Voter\MediaVoter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class GuestPermissionEditMediaOfOtherUserTest extends TestCase
{
    public function testGuestCannotEditMediaOfOtherUser(): void
    {
       $voter = new MediaVoter();

       $owner = new User();
       $owner->setEmail('owner@exemple.com');
       $guest = new User();
       $guest->setEmail('guest@exemple.com');
       $media = $this->createMedia($owner);

       $token = new UsernamePasswordToken($guest, 'password',$guest->getRoles());

       $result = $voter->vote($token, $media, [MediaVoter::MANAGE]);

       $this->assertEquals(VoterInterface::ACCESS_DENIED, $result);


    }


    private static function createMedia($user): Media
    {
        $media = new Media();
        $media->setTitle('Test title');
        $media->setPath('Test path');
        $media->setUser($user);
        return $media;
    }

}
