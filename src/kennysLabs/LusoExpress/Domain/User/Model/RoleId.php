<?php
namespace kennysLabs\LusoExpress\Domain\User\Model;

use kennysLabs\LusoExpress\Domain\Shared\Model\UniqueIdentifierInterface;

/**
 * Class RoleId
 */
final class RoleId implements UniqueIdentifierInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function toInteger()
    {
        return $this->id;
    }
}
