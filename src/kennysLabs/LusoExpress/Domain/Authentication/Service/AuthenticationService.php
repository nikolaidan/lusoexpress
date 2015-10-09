<?php
namespace kennysLabs\LusoExpress\Domain\Authentication\Service;

use kennysLabs\LusoExpress\Domain\User\Model\User;

/**
 * Class AuthenticationService
 */
final class AuthenticationService
{
    /**
     * @param string $password
     * @param User $user
     *
     * @return bool
     */
    public function verifyPassword($password, User $user)
    {
        return password_verify($password, $user->getPasswordHash()->toString());
    }
}
