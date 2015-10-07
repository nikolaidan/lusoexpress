<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Event;

/**
 * Interface EventBus
 */
interface EventBusInterface
{
    /**
     * Posts an event to all registered listeners
     *
     * @param EventInterface $event
     *
     * @return void
     */
    public function post(EventInterface $event);
}
