<?php
namespace kennysLabs\LusoExpress\Domain\User\Change;

use kennysLabs\LusoExpress\Domain\User\Event\UserUpdatedEvent;
use kennysLabs\LusoExpress\Domain\User\Model\UserActive;
use kennysLabs\LusoExpress\Domain\User\Model\UserName;
use kennysLabs\LusoExpress\Domain\User\Model\UserUuid;
use kennysLabs\LusoExpress\Domain\Shared\Change\HasChangeName;
use kennysLabs\LusoExpress\Domain\Shared\Change\PublishableChangeInterface;


class UpdateUserChange implements PublishableChangeInterface
{
    use HasChangeName;

    /**
     * @var UserUuid
     */
    private $uuid;

    /**
     * @var UserName $name
     */
    private $name;

    /**
     * @var UserActive $active
     */
    private $active;

    /**
     * @param UserUuid $uuid
     * @param UserName $name
     * @param UserActive $active
     */
    public function __construct(UserUuid $uuid, UserName $name, UserActive $active)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->active = $active;
    }

    /**
     * @return UserUuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return UserName
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return UserActive
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @inheritdoc
     */
    public function toEvent()
    {
        return new UserUpdatedEvent($this->uuid, $this->name);
    }
}
