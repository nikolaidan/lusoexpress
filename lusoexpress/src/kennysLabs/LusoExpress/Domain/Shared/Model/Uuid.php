<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Model;

/**
 * Class UUID
 */
abstract class Uuid implements UniqueIdentifierInterface
{
    const VALID_PATTERN = '^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$';

    /**
     * @var string
     */
    protected $uuid;

    /**
     * @param string $uuid
     */
    final public function __construct($uuid)
    {
        $pattern = '/' . self::VALID_PATTERN . '/';

        if (! \preg_match($pattern, $uuid)) {
            throw new \InvalidArgumentException("'" . $uuid . "' is not a valid UUID.");
        }

        $this->uuid = (string) $uuid;
    }

    /**
     * @return string
     */
    final public function toString()
    {
        return $this->uuid;
    }
}
