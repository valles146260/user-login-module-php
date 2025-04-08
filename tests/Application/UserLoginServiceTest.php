<?php

declare(strict_types=1);

namespace UserLoginService\Tests\Application;

use PHPUnit\Framework\TestCase;
use UserLoginService\Application\UserLoginService;
use UserLoginService\Domain\User;
use UserLoginService\Infrastructure\FacebookSessionManager;

use Mockery;

final class UserLoginServiceTest extends TestCase
{

    /**
     * @test
     */
    public function userAlreadyLoggedIn()
    {
        $user = new User("Asier");
        $userLoginService = new UserLoginService([]);

        $this->expectExceptionMessage("User already logged in");
        $userLoginService->manualLogin($user);
        $userLoginService->manualLogin($user);
    }

    /**
     * @test
     */
    public function userIsLoggedIn()
    {
        $user = new User("Asier");
        $userLoginService = new UserLoginService([]);

        $userLoginService->manualLogin($user);

        $this->assertEquals("Asier", $userLoginService->getLoggedUser($user));
    }

    /**
     * @test
     */
    public function getNumberOfSession()
    {
        $facebookManager = Mockery::mock(FacebookSessionManager::class);
        $facebookManager->shouldReceive('getSessions')
            ->once()
            ->andReturn(4);
        $userLoginService = new UserLoginService([], $facebookManager);

        $this->assertEquals(4, $userLoginService->getExternalSession());
    }
}
