<?php
namespace kennysLabs\LusoExpress\Domain\User\Event;

use kennysLabs\LusoExpress\Domain\User\Model\UserUuid;
use kennysLabs\LusoExpress\Domain\User\Model\UserName;
use kennysLabs\LusoExpress\Domain\Shared\Event\EventInterface;

/**
 * Class UserUpdatedEvent
 */
class UserUpdatedEvent implements EventInterface
{
    /**
     * @var string
     */
    protected $userUuid;

    /**
     * @param UserUuid $userUuid
     */
    public function __construct(UserUuid $userUuid, UserName $userName)
    {
        $this->userUuid = $userUuid->toString();
        $this->userName = $userName->toString();
    }

    /**
     * @inheritdoc
     */
    public function getEventName()
    {
        return 'user.update';
    }

    /**
     * @inheritdoc
     */
    public function serialize()
    {
        return [$this->getEventName() => ['uuid' => $this->userUuid]];
    }
}
