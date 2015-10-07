<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Event;

/**
 * Interface EventSubscriber
 * An EventSubscriber receives Events from an EventBus
 */
interface EventSubscriberInterface
{
    /**
     * Returns an array of subscribed events where array kes are event names
     * and array values are event handler method names.
     *
     * @return array
     */
    public function getSubscribedEvents();

    /**
     * @return []
     */
    public function getNotifications();
}
