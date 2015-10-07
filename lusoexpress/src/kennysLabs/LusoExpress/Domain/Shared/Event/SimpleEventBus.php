<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Event;

/**
 * Class SimpleEventBus
 */
class SimpleEventBus implements EventBusInterface
{
    /**
     * @var \SplObjectStorage
     */
    protected $subscribers;

    public function __construct()
    {
        $this->subscribers = new \SplObjectStorage();
    }

    /**
     * Posts an event to all registered handlers
     *
     * @param EventInterface $event
     */
    public function post(EventInterface $event)
    {
        foreach ($this->subscribers as $subscriber) {
            $this->dispatch($event, $subscriber);
        }
    }

    /**
     * @param EventSubscriberInterface $subscriber
     */
    public function register(EventSubscriberInterface $subscriber)
    {
        $this->subscribers->attach($subscriber);
    }

    /**
     * @param EventSubscriberInterface $subscriber
     */
    public function deregister(EventSubscriberInterface $subscriber)
    {
        $this->subscribers->detach($subscriber);
    }

    /**
     * @param EventInterface $event
     * @param EventSubscriberInterface $subscriber
     */
    protected function dispatch(EventInterface $event, EventSubscriberInterface $subscriber)
    {
        $subscribedEvents = $subscriber->getSubscribedEvents();

        foreach ($subscribedEvents as $eventName => $method) {
            if ($eventName == $event->getEventName()) {
                $subscriber->$method($event);
            }
        }
    }
}
