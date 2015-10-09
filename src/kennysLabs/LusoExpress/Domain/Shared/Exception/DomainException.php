<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Exception;

use Exception;

/**
 * Class DomainException
 */
abstract class DomainException extends \RuntimeException
{
    /**
     * @var string
     */
    protected $errorType;

    /**
     * @param string $message
     * @param string $errorType
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message = '', $errorType = 'generic', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errorType = $errorType;
    }

    /**
     * @return string
     */
    public function getErrorType()
    {
        return $this->errorType;
    }

    /**
     * @param string $errorType
     */
    public function setErrorType($errorType)
    {
        $this->errorType = $errorType;
    }
}
