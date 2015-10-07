<?php
namespace kennysLabs\LusoExpress\Domain\Shared\UnitOfWork;

use kennysLabs\LusoExpress\Domain\Shared\Event\EventInterface;
use kennysLabs\LusoExpress\Domain\Shared\Model\UniqueIdentifierInterface;
use kennysLabs\LusoExpress\Domain\Shared\Model\EntityInterface;

/**
 * Interface UnitOfWork
 */
interface UnitOfWorkInterface
{
    /**
     * Adds an Entity to UnitOfWork tracking
     *
     * @param EntityInterface $entity
     *
     * @return mixed
     */
    public function add(EntityInterface $entity);

    /**
     * Persists the Entities tracked by UnitOfWork
     *
     * @return mixed
     */
    public function commit();

    /**
     * Loads an entity from the persistent storage.
     * This entity will be tracked Automatically
     *
     * @param UniqueIdentifierInterface $id
     *
     * @return EntityInterface
     */
    public function findById(UniqueIdentifierInterface $id);

    /**
     * Sends an exception to the EventBus
     *
     * @param EventInterface $event
     *
     * @return mixed
     */
    public function handleException(EventInterface $event);
}
