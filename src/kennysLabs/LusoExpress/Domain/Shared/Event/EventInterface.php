<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Event;

/**
 * Interface Event
 */
interface EventInterface
{
    /**
     * Returns event name
     *
     * @return string
     */
    public function getEventName();

    /**
     * @return array
     */
    public function serialize();
}
