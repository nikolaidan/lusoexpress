<?php
namespace kennysLabs\LusoExpress\Domain\User\Repository;

use kennysLabs\LusoExpress\Domain\User\Model\User;
use kennysLabs\LusoExpress\Domain\User\Model\UserEmail;
use kennysLabs\LusoExpress\Domain\User\Query\UserList;
use kennysLabs\LusoExpress\Domain\Shared\Model\UniqueIdentifierInterface;
use kennysLabs\LusoExpress\Domain\Shared\Repository\RepositoryInterface;

/**
 * Interface UserRepositoryInterface
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UserList $userList
     *
     * @return User[]
     */
    public function findBy(UserList $userList);

    /**
     * @param UniqueIdentifierInterface $id
     *
     * @return null|User
     */
    public function findById(UniqueIdentifierInterface $id);

    /**
     * @param UserEmail $email
     *
     * @return User|null
     */
    public function findByEmail(UserEmail $email);

    /**
     * @param UserList $userList
     *
     * @return int
     */
    public function getUsersCount(UserList $userList);
}
