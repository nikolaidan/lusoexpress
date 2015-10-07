<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Change;

/**
 * Interface PublishableChange
 * A Publishable Change is a Change that can be turned into a public Event
 */
interface PublishableChangeInterface extends ChangeInterface
{
    /**
     * @return \kennysLabs\LusoExpress\Domain\Shared\Event\EventInterface;
     */
    public function toEvent();
}
