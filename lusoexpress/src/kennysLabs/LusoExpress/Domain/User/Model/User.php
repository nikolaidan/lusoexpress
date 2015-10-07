<?php

namespace kennysLabs\LusoExpress\Domain\User\Model;

use kennysLabs\LusoExpress\Domain\User\Change\CreateUserChange;
use kennysLabs\LusoExpress\Domain\User\Change\UpdateUserChange;
use kennysLabs\LusoExpress\Domain\User\Change\UpdateUserPasswordChange;
use kennysLabs\LusoExpress\Domain\User\Command\UserPasswordUpdateCommand;
use kennysLabs\LusoExpress\Domain\User\Command\UserUpdateCommand;

use kennysLabs\LusoExpress\Domain\Shared\Change\HasChangeSet;
use kennysLabs\LusoExpress\Domain\Shared\Model\EntityInterface;

final class User implements EntityInterface
{
    use HasChangeSet;

    /**
     * @var UserUuid
     */
    private $uuid;

    /**
     * @var UserName
     */
    private $name;

    /**
     * @var UserEmail
     */
    private $email;

    /**
     * @var PasswordHash
     */
    private $passwordHash;

    /**
     * @var UserActive
     */
    private $active;

    /**
     * @var Role
     */
    private $role;

    /**
     * @param UserUuid $uuid
     * @param UserName $name
     * @param UserEmail $email
     * @param PasswordHash $passwordHash
     * @param UserActive $active
     * @param Role $role
     */
    public function __construct(
        UserUuid $uuid,
        UserName $name,
        UserEmail $email,
        PasswordHash $passwordHash,
        UserActive $active,
        Role $role
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->active = $active;
        $this->role = $role;
    }

    /**
     * @param string $uuid
     * @param string $name
     * @param string $email
     * @param string $password
     * @param Role $role
     *
     * @return self
     */
    public static function create(
        $uuid,
        $name,
        $email,
        $password,
        Role $role
    ) {
        $userId = new UserUuid($uuid);
        $userName = new UserName($name);
        $userEmail = new UserEmail($email);
        $userPassword = new Password($password);
        $userActive = new UserActive(false);

        $user = new self(
            $userId,
            $userName,
            $userEmail,
            $userPassword->toPasswordHash(),
            $userActive,
            $role
        );

        $createUserChange = new CreateUserChange(
            $userId,
            $userName,
            $userEmail,
            $userPassword,
            $userActive,
            $role
        );

        $user->trackChange($createUserChange);

        return $user;
    }

    /**
     * @param UserUpdateCommand $userUpdate
     */
    public function updateUser(UserUpdateCommand $userUpdate)
    {
        $updateUserChange = new UpdateUserChange(
            $userUpdate->getUuid(),
            new UserName($userUpdate->getName()),
            new UserActive($userUpdate->isActive())
        );

        $this->trackChange($updateUserChange);
    }

    /**
     * @param UserPasswordUpdateCommand $userPasswordUpdate
     */
    public function updateUserPassword(UserPasswordUpdateCommand $userPasswordUpdate)
    {
        $updateUserPasswordChange = new UpdateUserPasswordChange(
            $userPasswordUpdate->getUuid(),
            $userPasswordUpdate->getPasswordHash()
        );

        $this->trackChange($updateUserPasswordChange);
    }

    /**
     * @return UserUuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return UserName
     */
    public function getUserName()
    {
        return $this->name;
    }

    /**
     * @return UserEmail
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return PasswordHash
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * @return UserActive
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }
}
