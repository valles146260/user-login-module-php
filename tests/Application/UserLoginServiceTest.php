<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use PHPUnit\Framework\TestCase;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;

final class UserLoginServiceTest extends TestCase
{
    /**
     * @test
     */
    public function userAlreadyLoggedIn(): void
    {
        $user = new User("Iñigo");
        $userLoginService = new UserLoginService();

        $this->expectExceptionMessage("User already logged in");

        $userLoginService->manualLogin($user);
        $userLoginService->manualLogin($user);
    }

    /**
     * @test
     */
    public function userIsLoggedIn(): void
    {
        $user = new User("Iñigo");
        $userLoginService = new UserLoginService();

        $userLoginService->manualLogin($user);

        $this->assertEquals("Iñigo", $userLoginService->getLoggedUser($user));
    }
}
