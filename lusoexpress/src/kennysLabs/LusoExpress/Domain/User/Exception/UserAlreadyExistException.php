<?php
namespace kennysLabs\LusoExpress\Domain\User\Exception;


use kennysLabs\LusoExpress\Domain\Shared\Exception\DomainException;
use kennysLabs\LusoExpress\Domain\Shared\Exception\DomainExceptionInterface;

/**
 * Class UserAlreadyExistException
 */
class UserAlreadyExistException extends DomainException implements DomainExceptionInterface
{
    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'errorType' => 'UserAlreadyExistError',
            'message' => 'An user with the given email already exists.',
        ];
    }
}
