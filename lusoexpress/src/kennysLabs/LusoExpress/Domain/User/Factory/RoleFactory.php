<?php

namespace kennysLabs\LusoExpress\Domain\User\Factory;

use kennysLabs\LusoExpress\Domain\User\Model\Role;
use kennysLabs\LusoExpress\Domain\User\Model\RoleId;
use kennysLabs\LusoExpress\Domain\User\Model\RoleLabel;
use kennysLabs\LusoExpress\Domain\User\Model\RolePermission;

/**
 * Class RoleFactory
 */
class RoleFactory
{
    /**
     * @param int $roleId
     * @param string $roleLabel
     * @param int $rolePermission
     *
     * @return Role
     */
    public function createRole($roleId, $roleLabel, $rolePermission)
    {
        return new Role(
            new RoleId($roleId),
            new RoleLabel($roleLabel),
            new RolePermission($rolePermission)
        );
    }
}
