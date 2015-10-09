<?php
namespace kennysLabs\LusoExpress\Domain\User\Model;

use kennysLabs\LusoExpress\Domain\Shared\Change\HasChangeSet;
use kennysLabs\LusoExpress\Domain\Shared\Model\EntityInterface;

/**
 * Class Role
 */
final class Role implements EntityInterface
{
    use HasChangeSet;

    /**
     * @var RoleId
     */
    private $id;

    /**
     * @var RoleLabel
     */
    private $label;

    /**
     * @var RolePermission
     */
    private $permission;

    /**
     * @param RoleId $id
     * @param RoleLabel $label
     * @param RolePermission $permission
     */
    public function __construct(RoleId $id, RoleLabel $label, RolePermission $permission)
    {
        $this->id = $id;
        $this->label = $label;
        $this->permission = $permission;
    }

    /**
     * @return RoleId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return RoleLabel
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return RolePermission
     */
    public function getPermission()
    {
        return $this->permission;
    }
}
