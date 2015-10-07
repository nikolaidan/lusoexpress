<?php
namespace kennysLabs\LusoExpress\Domain\User\Event;

use kennysLabs\LusoExpress\Domain\User\Model\UserEmail;
use kennysLabs\LusoExpress\Domain\User\Model\UserName;
use kennysLabs\LusoExpress\Domain\User\Model\UserUuid;
use kennysLabs\LusoExpress\Domain\Shared\Event\EventInterface;

/**
 * Class UserCreatedEvent
 */
class UserCreatedEvent implements EventInterface
{
    /**
     * @var string
     */
    protected $userUuid;

    /**
     * @var string
     */
    protected $userName;

    /**
     * @var string
     */
    protected $userEmail;

    /**
     * @param UserUuid $userUuid
     * @param UserName $userName
     * @param UserEmail $email
     */
    public function __construct(
        UserUuid $userUuid,
        UserName $userName,
        UserEmail $email
    ) {
        $this->userUuid = $userUuid->toString();
        $this->userName = $userName->toString();
        $this->userEmail = $email->toString();
    }

    /**
     * @inheritdoc
     */
    public function getEventName()
    {
        return 'user.create';
    }

    /**
     * @inheritdoc
     */
    public function serialize()
    {
        return [$this->getEventName() => [
            'uuid' => $this->userUuid,
            'name' => $this->userName,
            'email' => $this->userEmail,
        ]];
    }
}
