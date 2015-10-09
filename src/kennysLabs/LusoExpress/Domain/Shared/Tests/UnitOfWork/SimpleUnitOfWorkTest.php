<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Tests\UnitOfWork;

use kennysLabs\LusoExpress\Domain\Shared\Change\ChangeSet;
use kennysLabs\LusoExpress\Domain\Shared\Change\PublishableChangeInterface;
use kennysLabs\LusoExpress\Domain\Shared\Event\EventBusInterface;
use kennysLabs\LusoExpress\Domain\Shared\Event\EventInterface;
use kennysLabs\LusoExpress\Domain\Shared\Model\UniqueIdentifierInterface;
use kennysLabs\LusoExpress\Domain\Shared\Model\EntityInterface;
use kennysLabs\LusoExpress\Domain\Shared\Repository\RepositoryInterface;
use kennysLabs\LusoExpress\Domain\Shared\Tests\UnitTestCase;
use kennysLabs\LusoExpress\Domain\Shared\UnitOfWork\SimpleUnitOfWork;

/**
 * Class SimpleUnitOfWorkTest
 */
class SimpleUnitOfWorkTest extends UnitTestCase
{
    /**
     * @test
     */
    public function commitSavesTrackedEntity()
    {
        $repository = $this->getMock(RepositoryInterface::class);
        $entity = $this->getMock(EntityInterface::class);
        $changeSet = new ChangeSet();

        $repository->expects(static::once())
            ->method('save')
            ->with($changeSet);

        $entity->expects(static::once())
            ->method('flushChanges')
            ->willReturn($changeSet);

        $eventBus = $this->getMock(EventBusInterface::class);

        /** @var RepositoryInterface $repository */
        /** @var EventBusInterface $eventBus */
        $unitOfWork = new SimpleUnitOfWork($repository, $eventBus);

        /** @var EntityInterface $entity */
        $unitOfWork->add($entity);
        $unitOfWork->commit();
    }

    /**
     * @test
     */
    public function commitPostsEvent()
    {
        $repository = $this->getMock(RepositoryInterface::class);
        $entity = $this->getMock(EntityInterface::class);
        $id = $this->getMock(UniqueIdentifierInterface::class);
        $eventBus = $this->getMock(EventBusInterface::class);
        $event = $this->getMock(EventInterface::class);
        $change = $this->getMock(PublishableChangeInterface::class);
        $changeSet = new ChangeSet();

        $repository->expects(static::any())
            ->method('findById')
            ->with($id)
            ->willReturn($entity);

        $entity->expects(static::once())
            ->method('flushChanges')
            ->willReturn($changeSet);

        $change->expects(static::once())
            ->method('toEvent')
            ->willReturn($event);

        $eventBus->expects(static::once())
            ->method('post')
            ->with($event);

        /** @var PublishableChangeInterface $change */
        $changeSet->addChange($change);

        /** @var RepositoryInterface $repository */
        /** @var EventBusInterface $eventBus */
        $unitOfWork = new SimpleUnitOfWork($repository, $eventBus);

        /** @var UniqueIdentifierInterface $id */
        $unitOfWork->findById($id);
        $unitOfWork->commit();
    }
}
