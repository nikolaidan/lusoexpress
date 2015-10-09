<?php
namespace kennysLabs\LusoExpress\Domain\User\Model;

/**
 * Class RolePermission
 */
class RolePermission
{
    /**
     * @var int
     */
    private $permission;

    /**
     * @param int $permission
     */
    public function __construct($permission)
    {
        $this->permission = (int) $permission;
    }

    public function toInteger()
    {
        return $this->permission;
    }
}
