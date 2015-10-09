<?php
namespace kennysLabs\LusoExpress\Domain\Shared\UnitOfWork;

use kennysLabs\LusoExpress\Domain\Shared\Change\ChangeSet;
use kennysLabs\LusoExpress\Domain\Shared\Event\EventBusInterface;
use kennysLabs\LusoExpress\Domain\Shared\Event\EventInterface;
use kennysLabs\LusoExpress\Domain\Shared\Model\UniqueIdentifierInterface;
use kennysLabs\LusoExpress\Domain\Shared\Model\EntityInterface;
use kennysLabs\LusoExpress\Domain\Shared\Repository\RepositoryInterface;
use kennysLabs\LusoExpress\Domain\Shared\Exception\EntityNotFoundException;

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
     * @inheritdoc
     */
    public function add(EntityInterface $entity)
    {
        $this->entities->attach($entity);
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
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
    public function loadById(UniqueIdentifierInterface $id)
    {
        $entity = $this->repository->findById($id);

        if (null === $entity) {
            throw new EntityNotFoundException();
        }
        $this->add($entity);

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
