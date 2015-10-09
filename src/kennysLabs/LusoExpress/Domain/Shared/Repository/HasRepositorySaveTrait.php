<?php

namespace kennysLabs\LusoExpress\Domain\Shared\Repository;

use kennysLabs\LusoExpress\Domain\Shared\Change\ChangeSet;
use kennysLabs\LusoExpress\Domain\Shared\Exception\MethodNotImplementedDomainException;

/**
 * Trait HasRepositorySaveTrait
 */
trait HasRepositorySaveTrait
{
    /**
     * @param ChangeSet $changeSet
     * @uses UserRepository::handleCreateUserChange
     * @throws MethodNotImplementedDomainException
     */
    public function save(ChangeSet $changeSet)
    {
        foreach ($changeSet->getChanges() as $change) {
            $methodName = 'handle' . $change->getChangeName();

            if (!method_exists($this, $methodName)) {
                throw new MethodNotImplementedDomainException();
            }

            $this->$methodName($change);
        }
    }
}
