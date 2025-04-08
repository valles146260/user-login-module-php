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
     * @throws \Exception
     */
    public function userAlreadyLoggedIn(): void
    {
        $user = new User("Asier");
        $FacebookSessionManager = new FacebookSessionManager();
        $userLoginService = new UserLoginService($FacebookSessionManager);

        $userLoginService->manualLogin($user);

        // Debe lanzar un mensaje de excepción si el usuario ya está logueado
        $this->expectExceptionMessage("User already logged in");
        $userLoginService->manualLogin($user);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function userIsLoggedIn(): void
    {
        $user = new User("Asier");

        $FacebookSessionManager = new FacebookSessionManager();
        $userLoginService = new UserLoginService($FacebookSessionManager);

        $userLoginService->manualLogin($user);

        // Comparar que el usuario logueado corresponde con el usuario esperado
        $this->assertSame("Asier", $userLoginService->getLoggedUser($user));
    }

    /**
     * @test
     */
    public function getNumberOfSession(): void
    {
        // Crear el mock de la dependencia
        $facebookSessionManager = Mockery::mock(FacebookSessionManager::class);
        $facebookSessionManager->allows()->getSessions()->andReturn(4);

        // Inyectar el mock en UserLoginService
        $userLoginService = new UserLoginService($facebookSessionManager);

        // Comprobar que devuelve el número correcto de sesiones
        $this->assertSame(4, $userLoginService->getExternalSession());
    }
}

