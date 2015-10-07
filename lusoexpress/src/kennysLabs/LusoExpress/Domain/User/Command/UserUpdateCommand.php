<?php
namespace kennysLabs\LusoExpress\Domain\User\Command;

use kennysLabs\LusoExpress\Domain\User\Model\UserUuid;
use kennysLabs\LusoExpress\Domain\Shared\Command\CommandInterface;

/**
 * Class UserUpdateCommand
 */
class UserUpdateCommand implements CommandInterface
{
    /**
     * @var UserUuid
     */
    private $uuid;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $active;

    /**
     * @param UserUuid $uuid
     * @param string $name
     * @param bool $active
     */
    public function __construct($uuid, $name, $active)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return UserUuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }
}
