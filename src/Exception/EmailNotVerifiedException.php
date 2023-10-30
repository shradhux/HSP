<?php

namespace App\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class EmailNotVerifiedException extends AuthenticationException
{
    // Vous pouvez ajouter des méthodes ou personnaliser le comportement si nécessaire
}