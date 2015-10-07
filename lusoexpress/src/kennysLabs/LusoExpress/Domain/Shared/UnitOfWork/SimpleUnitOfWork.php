<?php
namespace kennysLabs\LusoExpress\Domain\Shared\UnitOfWork;

use kennysLabs\LusoExpress\Domain\Shared\Change\ChangeSet;
use kennysLabs\LusoExpress\Domain\Shared\Event\EventBusInterface;
use kennysLabs\LusoExpress\Domain\Shared\Event\EventInterface;
use kennysLabs\LusoExpress\Domain\Shared\Model\UniqueIdentifierInterface;
use kennysLabs\LusoExpress\Domain\Shared\Model\EntityInterface;
use kennysLabs\LusoExpress\Domain\Shared\Repository\RepositoryInterface;

final class SimpleUnitOfWork implements UnitOfWorkInterface
{
    /**
     * @var RepositoryInterface $repository
     */
    private $repository;

    /**
     * @var \SplObjectStorage $entities
     */
    private $entities;

    /**
     * @var EventBusInterface $eventBus
     */
    private $eventBus;

    /**
     * @param RepositoryInterface $repository
     * @param EventBusInterface $eventBus
     */
    public function __construct(RepositoryInterface $repository, EventBusInterface $eventBus)
    {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
        $this->entities = new \SplObjectStorage();
    }

    /**
     * Adds an Entity to UnitOfWork tracking
     *
     * @param EntityInterface $entity
     *
     * @return mixed
     */
    public function add(EntityInterface $entity)
    {
        $this->entities->attach($entity);
    }

    /**
     * Persists the Entities tracked by UnitOfWork
     *
     * @return mixed
     */
    public function commit()
    {
        /** @var EntityInterface $entity */
        foreach ($this->entities as $entity) {
            /** @var ChangeSet $changeSet */
            $changeSet = $entity->flushChanges();
            $this->repository->save($changeSet);

            foreach ($changeSet->toEvents() as $event) {
                $this->eventBus->post($event);
            }
        }
    }

    /**
     * Loads an entity from the persistent storage.
     * This entity will be tracked Automatically
     *
     * @param UniqueIdentifierInterface $id
     *
     * @return EntityInterface|null
     */
    public function findById(UniqueIdentifierInterface $id)
    {
        $entity = $this->repository->findById($id);

        if (null !== $entity) {
            $this->add($entity);
        }

        return $entity;
    }

    /**
     * @inheritdoc
     */
    public function handleException(EventInterface $event)
    {
        $this->eventBus->post($event);
    }
}
