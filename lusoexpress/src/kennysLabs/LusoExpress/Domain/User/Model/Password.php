<?php

namespace kennysLabs\LusoExpress\Domain\User\Model;

/**
 * Class Password
 */
final class Password
{
    /**
     * @var string $password
     */
    private $password;

    /**
     * @param string $password
     */
    public function __construct($password)
    {
        if (strlen($password) < 8) {
            throw new \InvalidArgumentException('The defined password is too short.');
        }

        $this->password = $password;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->password;
    }

    /**
     * @return PasswordHash
     */
    public function toPasswordHash()
    {
        return new PasswordHash(
            password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 12])
        );
    }
}
