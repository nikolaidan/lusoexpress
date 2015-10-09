<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Exception;

/**
 * Class EntityNotFoundException
 */
class EntityNotFoundException extends DomainException implements DomainExceptionInterface
{
    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'errorType' => $this->getErrorType(),
            'message' => $this->getMessage(),
        ];
    }
}
