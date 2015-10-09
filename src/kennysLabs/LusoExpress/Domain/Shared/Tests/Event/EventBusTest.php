<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Tests\Event;

use kennysLabs\LusoExpress\Domain\Shared\Event\EventInterface;
use kennysLabs\LusoExpress\Domain\Shared\Event\EventSubscriberInterface;
use kennysLabs\LusoExpress\Domain\Shared\Event\SimpleEventBus;
use kennysLabs\LusoExpress\Domain\Shared\Tests\UnitTestCase;

/**
 * Class EventBusTest
 */
class EventBusTest extends UnitTestCase
{
    /**
     * @test
     */
    public function eventIsDispatched()
    {
        $testEvent = $this->getMock(EventInterface::class);
        $testEvent->expects(static::once())->method('getEventName')->willReturn('event.name');

        $testSubscriber = $this->getMockBuilder(EventSubscriberInterface::class)
            ->setMethods(['onEventName', 'getSubscribedEvents', 'getNotifications'])
            ->getMock();
        $testSubscriber
            ->expects(static::once())
            ->method('getSubscribedEvents')
            ->willReturn(['event.name' => 'onEventName']);
        $testSubscriber->expects(static::once())
            ->method('onEventName')
            ->with(static::equalTo($testEvent));

        $eventBus = new SimpleEventBus();

        /** @var EventSubscriberInterface $testSubscriber */
        $eventBus->register($testSubscriber);
        /** @var EventInterface $testEvent */
        $eventBus->post($testEvent);
    }

    /**
     * @test
     */
    public function eventIsNotDispatchedToUnregisteredSubscriber()
    {
        $testEvent = $this->getMock(EventInterface::class);
        $testEvent->expects(static::never())->method('getEventName')->willReturn('event.name');

        $testSubscriber = $this->getMockBuilder(EventSubscriberInterface::class)
            ->setMethods(['onEventName', 'getSubscribedEvents', 'getNotifications'])
            ->getMock();
        $testSubscriber
            ->expects(static::never())
            ->method('getSubscribedEvents')
            ->willReturn(['event.name' => 'onEventName']);
        $testSubscriber->expects(static::never())
            ->method('onEventName')
            ->with(static::equalTo($testEvent));

        $eventBus = new SimpleEventBus();

        /** @var EventSubscriberInterface $testSubscriber */
        $eventBus->register($testSubscriber);
        $eventBus->deregister($testSubscriber);
    }
}
