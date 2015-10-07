<?php
namespace kennysLabs\LusoExpress\Domain\User\Event;

use kennysLabs\LusoExpress\Domain\Shared\Event\EventSubscriberInterface;

/**
 * Class UserEventSubscriber
 */
class UserEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var array
     */
    private $notifications = [];

    /**
     * Returns an array of subscribed events where array keys are event names
     * and array values are event handler method names.
     *
     * @return array<string,string>
     */
    public function getSubscribedEvents()
    {
        return [
            'user.create' => 'userCreationEventHandler',
            'user.update' => 'userUpdateEventHandler',
            'user.exception' => 'userExceptionEventHandler',
            'user.password.update' => 'userPasswordUpdateEventHandler',
        ];
    }

    /**
     * @param UserCreatedEvent $userCreated
     */
    public function userCreationEventHandler(UserCreatedEvent $userCreated)
    {
        $this->notifications[] = $userCreated->serialize();
    }

    /**
     * @param UserUpdatedEvent $userUpdated
     */
    public function userUpdateEventHandler(UserUpdatedEvent $userUpdated)
    {
        $this->notifications[] = $userUpdated->serialize();
    }

    /**
     * @param UserExceptionEvent $userExceptionEvent
     */
    public function userExceptionEventHandler(UserExceptionEvent $userExceptionEvent)
    {
        $this->notifications[] = $userExceptionEvent->serialize();
    }

    /**
     * @param UserPasswordUpdatedEvent $userPasswordUpdate
     */
    public function userPasswordUpdateEventHandler(UserPasswordUpdatedEvent $userPasswordUpdate)
    {
        $this->notifications[] = $userPasswordUpdate->serialize();
    }

    /**
     * @return array
     */
    public function getNotifications()
    {
        return $this->notifications;
    }
}
