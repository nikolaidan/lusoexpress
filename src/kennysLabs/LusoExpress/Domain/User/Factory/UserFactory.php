<?php
namespace kennysLabs\LusoExpress\Domain\User\Factory;

use kennysLabs\LusoExpress\Domain\User\Model\PasswordHash;
use kennysLabs\LusoExpress\Domain\User\Model\Role;
use kennysLabs\LusoExpress\Domain\User\Model\RoleId;
use kennysLabs\LusoExpress\Domain\User\Model\User;
use kennysLabs\LusoExpress\Domain\User\Model\UserActive;
use kennysLabs\LusoExpress\Domain\User\Model\UserEmail;
use kennysLabs\LusoExpress\Domain\User\Model\UserName;
use kennysLabs\LusoExpress\Domain\User\Model\UserUuid;

use kennysLabs\LusoExpress\Domain\User\Repository\RoleRepositoryInterface;
use kennysLabs\LusoExpress\Infrastructure\Entity\Users as EntityUser;

/**
 * Class UserFactory
 */
class UserFactory
{
    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param EntityUser $entityUser
     * @return User
     */
    public function createUserFromEntity(EntityUser $entityUser)
    {
        /** @var Role $role */
        $role = $this->roleRepository->findById(new RoleId($entityUser->getRole()));

        return new User(
            new UserUuid($entityUser->getUuid()),
            new UserName($entityUser->getName()),
            new UserEmail($entityUser->getEmail()),
            new PasswordHash($entityUser->getPasswordHash()),
            new UserActive($entityUser->getActive()),
            $role
        );
    }
}
