<?php

namespace App\Security\Voter;

use App\Entity\Media;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class MediaVoter extends Voter
{
//    public const EDIT = 'POST_EDIT';
//    public const VIEW = 'POST_VIEW';
    public const MANAGE = 'MEDIA_MANAGE';

    protected function supports(string $attribute, mixed $subject): bool
    {
       return $attribute === self::MANAGE && $subject instanceof Media;
    }

    protected function voteOnAttribute(string $attribute,mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($attribute === self::MANAGE && $subject instanceof Media && null === $subject->getUser()) {
            return true;
        }

        if($user->isAdmin()){
            return true;
        }

        return $subject->getUser() === $user;
    }
}
