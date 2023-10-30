<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\UserSecurity;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        if (!$user->isVerified()) {
            // the message passed to this exception is meant to be displayed to the user
            throw new CustomUserMessageAccountStatusException("Votre adresse e-mail n\'a pas été vérifiée. Veuillez vérifier votre e-mail pour accéder à votre compte.");
        }
        if (!$user->isEstValide()) {
            // the message passed to this exception is meant to be displayed to the user
            throw new CustomUserMessageAccountStatusException("Votre compte est désactivé, veuillez contacter l'administrateur du site.");
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {

    }
}
