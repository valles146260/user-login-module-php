<?php

namespace UserLoginService\Application;

use Exception;
use UserLoginService\Domain\User;
use UserLoginService\Infrastructure\FacebookSessionManager;

class UserLoginService
{
    private array $loggedUsers = [];

    public function __construct(private FacebookSessionManager $facebookSessionManager)
    {
    }

    /**
     * @throws Exception
     */
    public function manualLogin(User $user): void
    {
        if ($this->isUserLogged($user)) {
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
        return $this->facebookSessionManager->getSessions();
    }

    public function manualLogout(User $user): string
    {
        if ($this->isUserLogged($user)) {
            return "Ok";
        }
        return "User not found";
    }

    public function isUserLogged(User $user): bool
    {
        return in_array($user->getUserName(), $this->loggedUsers);
    }

}