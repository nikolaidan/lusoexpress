<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Change;

use kennysLabs\LusoExpress\Domain\Shared\Event\EventInterface;

/**
 * Class ChangeSet
 * aggregator for Changes
 */
final class ChangeSet
{
    /**
     * @var ChangeInterface[]
     */
    private $changes = [];

    /**
     * @return ChangeInterface[]
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * @param ChangeInterface $change
     */
    public function addChange(ChangeInterface $change)
    {
        $this->changes[] = $change;
    }

    /**
     * Resets the change set
     */
    public function reset()
    {
        $this->changes = [];
    }

    /**
     * @return EventInterface[]
     */
    public function toEvents()
    {
        $events = [];

        foreach ($this->changes as $change) {
            if ($change instanceof PublishableChangeInterface) {
                $events[] = $change->toEvent();
            }
        }

        return $events;
    }
}
