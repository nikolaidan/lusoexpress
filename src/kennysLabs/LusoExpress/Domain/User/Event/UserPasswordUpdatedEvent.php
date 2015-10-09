<?php
namespace kennysLabs\LusoExpress\Domain\User\Event;

use kennysLabs\LusoExpress\Domain\Shared\Event\EventInterface;

/**
 * Class UserPasswordUpdatedEvent
 */
class UserPasswordUpdatedEvent implements EventInterface
{
    /**
     * @var string
     */
    protected $userUuid;

    /**
     * @param string $userUuid
     */
    public function __construct($userUuid)
    {
        $this->userUuid = $userUuid;
    }

    /**
     * @inheritdoc
     */
    public function getEventName()
    {
        return 'user.password.update';
    }

    /**
     * @inheritdoc
     */
    public function serialize()
    {
        return [$this->getEventName() => ['uuid' => $this->userUuid]];
    }
}
