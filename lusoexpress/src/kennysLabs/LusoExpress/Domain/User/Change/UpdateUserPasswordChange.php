<?php
namespace kennysLabs\LusoExpress\Domain\User\Change;

use kennysLabs\LusoExpress\Domain\User\Event\UserPasswordUpdatedEvent;
use kennysLabs\LusoExpress\Domain\User\Model\PasswordHash;
use kennysLabs\LusoExpress\Domain\User\Model\UserUuid;
use kennysLabs\LusoExpress\Domain\Shared\Change\HasChangeName;
use kennysLabs\LusoExpress\Domain\Shared\Change\PublishableChangeInterface;

/**
 * Class UpdateUserPasswordChange
 */
class UpdateUserPasswordChange implements PublishableChangeInterface
{
    use HasChangeName;

    /**
     * @var UserUuid
     */
    private $uuid;

    /**
     * @var PasswordHash $passwordHash
     */
    private $passwordHash;

    /**
     * @param UserUuid $uuid
     * @param PasswordHash $passwordHash
     */
    public function __construct(UserUuid $uuid, PasswordHash $passwordHash)
    {
        $this->uuid = $uuid;
        $this->passwordHash = $passwordHash;
    }

    /**
     * @return UserUuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return PasswordHash
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * @inheritdoc
     */
    public function toEvent()
    {
        return new UserPasswordUpdatedEvent($this->uuid->toString());
    }
}
