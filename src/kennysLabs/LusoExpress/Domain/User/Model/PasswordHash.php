<?php

namespace kennysLabs\LusoExpress\Domain\User\Model;

/**
 * Class PasswordHash
 */
final class PasswordHash
{
    /**
     * @var string
     */
    private $hash;

    /**
     * @param string $hash
     */
    public function __construct($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->hash;
    }
}
