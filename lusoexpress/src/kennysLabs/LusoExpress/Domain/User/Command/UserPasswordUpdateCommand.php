<?php
namespace kennysLabs\LusoExpress\Domain\User\Command;

use kennysLabs\LusoExpress\Domain\User\Model\PasswordHash;
use kennysLabs\LusoExpress\Domain\User\Model\UserUuid;
use kennysLabs\LusoExpress\Domain\Shared\Command\CommandInterface;

/**
 * Class UserPasswordUpdateCommand
 */
class UserPasswordUpdateCommand implements CommandInterface
{
    /**
     * @var UserUuid
     */
    private $uuid;

    /**
     * @var PasswordHash
     */
    private $passwordHash;

    /**
     * @param UserUuid $uuid
     * @param PasswordHash $passwordHash
     */
    public function __construct($uuid, $passwordHash)
    {
        $this->uuid = $uuid;
        $this->passwordHash = $passwordHash;
    }

    /**
     * @return PasswordHash
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * @return UserUuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }
}
