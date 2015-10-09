<?php
namespace kennysLabs\LusoExpress\Domain\User\Service;

use kennysLabs\LusoExpress\Domain\User\Model\Role;
use kennysLabs\LusoExpress\Domain\User\Model\RoleId;
use kennysLabs\LusoExpress\Domain\User\Repository\RoleRepository;

/**
 * Class RoleProvider
 */
final class RoleService
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * @param RoleRepository $roleRepository
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param int $id
     *
     * @return null|Role
     */
    public function getRoleById($id)
    {
        return $this->roleRepository->findById(new RoleId($id));
    }

    /**
     * @param string $label
     *
     * @return null|Role
     */
    public function getRoleByLabel($label)
    {
        return $this->roleRepository->findByLabel($label);
    }

    /**
     * @param int $permission
     *
     * @return null|Role
     */
    public function getRoleByPermission($permission)
    {
        return $this->roleRepository->findByPermission($permission);
    }

    /**
     * @param int $permission
     *
     * @return int[]
     */
    public function getRoleIdsByPermissionLowerOrEqualThan($permission)
    {
        return $this->roleRepository->getRoleIdsByPermissionLowerOrEqualThan($permission);
    }

    /**
     * Checks if the binary intersection of the roles contains the given role
     *
     * @param int $userRolePermission
     * @param Role $role
     *
     * @return bool
     */
    public function hasRole($userRolePermission, $role)
    {
        return ($userRolePermission & $role->getPermission()->toInteger()) === $userRolePermission;
    }
}
