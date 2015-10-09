<?php
namespace kennysLabs\LusoExpress\Domain\User\Event;

use kennysLabs\LusoExpress\Domain\Shared\Event\EventInterface;
use kennysLabs\LusoExpress\Domain\Shared\Exception\DomainExceptionInterface;

/**
 * Class UserExceptionEvent
 */
class UserExceptionEvent implements EventInterface
{
    /**
     * @var DomainExceptionInterface
     */
    protected $exception;

    /**
     * @param DomainExceptionInterface $exception
     */
    public function __construct(DomainExceptionInterface $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @inheritdoc
     */
    public function getEventName()
    {
        return 'user.exception';
    }

    /**
     * @inheritdoc
     */
    public function serialize()
    {
        return $this->exception->jsonSerialize();
    }
}
