<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Exception;

/**
 * Class MethodNotImplementedDomainException
 */
class MethodNotImplementedDomainException extends DomainException implements DomainExceptionInterface
{
    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'errorType' => 'SaveDisabledError',
            'message' => 'The save functionality is disabled.',
        ];
    }
}
