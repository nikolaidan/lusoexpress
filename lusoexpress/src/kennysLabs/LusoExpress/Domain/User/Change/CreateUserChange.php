<?php
namespace kennysLabs\LusoExpress\Domain\User\Change;

use kennysLabs\LusoExpress\Domain\User\Event\UserCreatedEvent;
use kennysLabs\LusoExpress\Domain\User\Model\Password;
use kennysLabs\LusoExpress\Domain\User\Model\Role;
use kennysLabs\LusoExpress\Domain\User\Model\UserActive;
use kennysLabs\LusoExpress\Domain\User\Model\UserEmail;
use kennysLabs\LusoExpress\Domain\User\Model\UserName;
use kennysLabs\LusoExpress\Domain\User\Model\UserUuid;
use kennysLabs\LusoExpress\Domain\Shared\Change\HasChangeName;
use kennysLabs\LusoExpress\Domain\Shared\Change\PublishableChangeInterface;

final class CreateUserChange implements PublishableChangeInterface
{
    use HasChangeName;

    /**
     * @var UserUuid
     */
    private $uuid;

    /**
     * @var UserName $name
     */
    private $name;

    /**
     * @var UserEmail $email
     */
    private $email;

    /**
     * @var Password $password
     */
    private $password;

    /**
     * @var UserActive $active
     */
    private $active;

    /**
     * @var Role $role
     */
    private $role;

    /**
     * @param UserUuid $userUuid
     * @param UserName $name
     * @param UserEmail $email
     * @param Password $password
     * @param UserActive $active
     * @param Role $role
     */
    public function __construct(
        UserUuid $userUuid,
        UserName $name,
        UserEmail $email,
        Password $password,
        UserActive $active,
        Role $role
    ) {
        $this->uuid = $userUuid;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->active = $active;
        $this->role = $role;
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
    public function getName()
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
     * @return Password
     */
    public function getPassword()
    {
        return $this->password;
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

    /**
     * @inheritdoc
     */
    public function toEvent()
    {
        return new UserCreatedEvent($this->uuid, $this->name, $this->email);
    }
}
