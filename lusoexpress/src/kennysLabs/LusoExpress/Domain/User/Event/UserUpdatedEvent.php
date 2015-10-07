<?php
namespace kennysLabs\LusoExpress\Domain\User\Event;

use kennysLabs\LusoExpress\Domain\User\Model\UserUuid;
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
    public function __construct(UserUuid $userUuid)
    {
        $this->userUuid = $userUuid->toString();
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
