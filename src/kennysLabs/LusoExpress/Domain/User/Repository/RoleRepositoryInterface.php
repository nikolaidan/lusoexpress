<?php
namespace kennysLabs\LusoExpress\Domain\User\Repository;

use kennysLabs\LusoExpress\Domain\User\Model\Role;
use kennysLabs\LusoExpress\Domain\Shared\Repository\RepositoryInterface;
use kennysLabs\LusoExpress\Domain\Shared\Model\UniqueIdentifierInterface;

/**
 * Interface RoleRepositoryInterface
 */
interface RoleRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UniqueIdentifierInterface $id
     *
     * @return Role|null
     */
    public function findById(UniqueIdentifierInterface $id);

    /**
     * @param string $label
     *
     * @return Role|null
     */
    public function findByLabel($label);

    /**
     * @param int $permission
     *
     * @return Role|null
     */
    public function findByPermission($permission);

    /**
     * @param int $permission
     *
     * @return int[]
     */
    public function getRoleIdsByPermissionLowerOrEqualThan($permission);
}
