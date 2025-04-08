<?php

namespace UserLoginService\Application;

use Exception;
use UserLoginService\Domain\User;
use UserLoginService\Infrastructure\FacebookSessionManager;

class UserLoginService
{
    private array $loggedUsers = [];
    private FacebookSessionManager $facebookManager;

    public function __construct(array $loggedUsers, ?FacebookSessionManager $facebookManager = null)
    {
        $this->loggedUsers = $loggedUsers;
        $this->facebookManager = $facebookManager ?? new FacebookSessionManager();
    }


    public function manualLogin(User $user): void
    {
        if (in_array($user->getUserName(), $this->loggedUsers)) {
            throw new Exception("User already logged in");
        }

        $this->loggedUsers[] = $user->getUserName();
    }

    public function getLoggedUser(User $user): string
    {
        return $user->getUserName();
    }

    public function getExternalSession(): int
    {
        return $this->facebookManager->getSessions();
    }

}