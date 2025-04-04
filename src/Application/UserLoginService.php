<?php

namespace UserLoginService\Application;

use RuntimeException;
use UserLoginService\Domain\User;

class UserLoginService
{
    private array $loggedUsers = [];

    public function manualLogin(User $user): void
    {
        if (in_array($user->getUserName(), $this->loggedUsers)) {
            throw new RuntimeException("User already logged in");
        }

        $this->loggedUsers[] = $user->getUserName();
    }



    public function getLoggedUser(User $user): string
    {
        return $user->getUserName();
    }

}