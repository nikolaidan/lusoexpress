<?php
namespace kennysLabs\LusoExpress\Domain\User\Exception;


use kennysLabs\LusoExpress\Domain\Shared\Exception\DomainException;
use kennysLabs\LusoExpress\Domain\Shared\Exception\DomainExceptionInterface;

/**
 * Class UserAlreadyExistException
 */
class UserNotFoundException extends DomainException implements DomainExceptionInterface
{
    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'errorType' => 'UserNotFoundError',
            'message' => 'This user could not be found.',
        ];
    }
}
