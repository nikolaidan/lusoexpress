<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Change;

/**
 * Trait HasChangeSet
 */
trait HasChangeSet
{
    /**
     * @var ChangeSet
     */
    private $changeSet;

    /**
     * @return ChangeSet
     */
    public function flushChanges()
    {
        $changeSet = clone $this->getChangeSet();
        $this->getChangeSet()->reset();

        return $changeSet;
    }

    /**
     * @param ChangeInterface $change
     */
    protected function trackChange(ChangeInterface $change)
    {
        $this->getChangeSet()->addChange($change);
    }

    /**
     * @return ChangeSet
     */
    private function getChangeSet()
    {
        if (null === $this->changeSet) {
            $this->changeSet = new ChangeSet();
        }

        return $this->changeSet;
    }
}
