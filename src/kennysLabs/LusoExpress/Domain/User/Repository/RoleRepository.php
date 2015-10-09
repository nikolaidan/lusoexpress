<?php
namespace kennysLabs\LusoExpress\Domain\User\Repository;

use kennysLabs\LusoExpress\Domain\User\Factory\RoleFactory;
use kennysLabs\LusoExpress\Domain\User\Model\Role;
use kennysLabs\LusoExpress\Domain\User\Model\RoleId;
use kennysLabs\LusoExpress\Domain\Shared\Change\ChangeSet;
use kennysLabs\LusoExpress\Domain\Shared\Exception\MethodNotImplementedDomainException;
use kennysLabs\LusoExpress\Domain\Shared\Model\UniqueIdentifierInterface;

/**
 * RoleProvider
 */
class RoleRepository implements RoleRepositoryInterface
{
    /**
     * @var array
     */
    private $roles;

    /**
     * @var RoleFactory
     */
    private $roleFactory;

    /**
     * @param array $roles
     * @param RoleFactory $roleFactory
     */
    public function __construct(array $roles, RoleFactory $roleFactory)
    {
        foreach ($roles as $label => $role) {
            $this->roles[$role['id']] = [
                'label' => $label,
                'permission' => $role['permission'],
            ];
        }
        $this->roleFactory = $roleFactory;
    }

    /**
     * @param UniqueIdentifierInterface $id
     *
     * @return Role|null
     */
    public function findById(UniqueIdentifierInterface $id)
    {
        /** @var RoleId $roleId */
        $collection = isset($this->roles[$id->toInteger()])
            ? $this->roles[$id->toInteger()]
            : false;

        if (false !== $collection) {
            return $this->roleFactory->createRole(
                $id->toInteger(),
                $collection['label'],
                $collection['permission']
            );
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function save(ChangeSet $changeSet)
    {
        throw new MethodNotImplementedDomainException();
    }

    /**
     * @param string $label
     *
     * @return Role|null
     */
    public function findByLabel($label)
    {
        $role = $this->getRoleByPosition(
            $this->getIndexFor('label', $label),
            $label
        );

        return null !== $role ? $role : null;
    }

    /**
     * @param int $permission
     *
     * @return Role|null
     */
    public function findByPermission($permission)
    {
        $role = $this->getRoleByPosition(
            $this->getIndexFor('permission', $permission)
        );

        return null !== $role ? $role : null;
    }

    /**
     * @inheritdoc
     */
    public function getRoleIdsByPermissionLowerOrEqualThan($permission)
    {
        $roleIds = [];
        foreach ($this->roles as $key => $role) {
            if ($permission >= $role['permission']) {
                $roleIds[] = $key;
            }
        }

        return $roleIds;
    }

    /**
     * @param bool|int $position
     * @param null|string $label
     *
     * @return null|Role
     */
    protected function getRoleByPosition($position, $label = null)
    {
        if (false !== $position) {
            $key = array_keys($this->roles)[$position];

            return $this->roleFactory->createRole(
                $key,
                $label ? $label : $this->roles[$key]['label'],
                $this->roles[$key]['permission']
            );
        }

        return null;
    }

    /**
     * @param string $column
     * @param string|int $value
     *
     * @return int|false
     */
    protected function getIndexFor($column, $value)
    {
        return array_search($value, array_column($this->roles, $column));
    }
}
