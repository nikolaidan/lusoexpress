<?php
namespace kennysLabs\LusoExpress\Domain\User\Tests\Model;

use kennysLabs\LusoExpress\Domain\User\Change\CreateUserChange;
use kennysLabs\LusoExpress\Domain\User\Change\UpdateUserChange;
use kennysLabs\LusoExpress\Domain\User\Change\UpdateUserPasswordChange;
use kennysLabs\LusoExpress\Domain\User\Command\UserPasswordUpdateCommand;
use kennysLabs\LusoExpress\Domain\User\Command\UserUpdateCommand;
use kennysLabs\LusoExpress\Domain\User\Factory\RoleFactory;
use kennysLabs\LusoExpress\Domain\User\Model\Password;
use kennysLabs\LusoExpress\Domain\User\Model\PasswordHash;
use kennysLabs\LusoExpress\Domain\User\Model\Role;
use kennysLabs\LusoExpress\Domain\User\Model\User;
use kennysLabs\LusoExpress\Domain\User\Model\UserActive;
use kennysLabs\LusoExpress\Domain\User\Model\UserEmail;
use kennysLabs\LusoExpress\Domain\User\Model\UserName;
use kennysLabs\LusoExpress\Domain\User\Model\UserUuid;
use kennysLabs\LusoExpress\Domain\Shared\Change\ChangeSet;
use kennysLabs\LusoExpress\Domain\Shared\Tests\UnitTestCase;

/**
 * Class UserTest
 */
final class UserTest extends UnitTestCase
{
    /**
     * @test
     */
    public function createGeneratesUserWithProperTypes()
    {
        $user = $this->createUser();

        static::assertInstanceOf(
            UserUuid::class,
            $user->getUuid()
        );

        static::assertInstanceOf(
            UserName::class,
            $user->getUserName()
        );

        static::assertInstanceOf(
            UserEmail::class,
            $user->getEmail()
        );

        static::assertInstanceOf(
            PasswordHash::class,
            $user->getPasswordHash()
        );

        static::assertInstanceOf(
            UserActive::class,
            $user->getActive()
        );

        static::assertInstanceOf(
            Role::class,
            $user->getRole()
        );

        $expectedChangeSet = new ChangeSet();
        $expectedChangeSet->addChange($this->getCreateUserChange($user));

        static::assertEquals($expectedChangeSet, $user->flushChanges());
    }

    /**
     * @test
     */
    public function updateGeneratesUserChangeSet()
    {
        $user = $this->createUser();

        $user->updateUser(
            new UserUpdateCommand(
                'de305d54-75b4-431b-adb2-eb6b9e546013',
                'NewName',
                false
            )
        );

        $user->updateUserPassword(
            new UserPasswordUpdateCommand(
                'de305d54-75b4-431b-adb2-eb6b9e546013',
                '-PASSWORD-'
            )
        );

        $changeSet = static::readAttribute(static::readAttribute($user, 'changeSet'), 'changes');

        $expectedChangeSet = new ChangeSet();
        $expectedChangeSet->addChange($this->getCreateUserChange($user));
        $expectedChangeSet->addChange(
            new UpdateUserChange(
                $user->getUuid(),
                new UserName('NewName'),
                new UserActive(false)
            )
        );
        $expectedChangeSet->addChange(
            new UpdateUserPasswordChange(
                $user->getUuid(),
                static::readAttribute($changeSet[2], 'passwordHash')
    )
        );

        static::assertEquals($expectedChangeSet, $user->flushChanges());
    }

    /**
     * @param User $user
     *
     * @return CreateUserChange
     */
    protected function getCreateUserChange(User $user)
    {
        return new CreateUserChange(
            $user->getUuid(),
            $user->getUserName(),
            $user->getEmail(),
            new Password('LengthyPassword'),
            $user->getActive(),
            $user->getRole()
        );
    }

    /**
     * @param User $user
     *
     * @return CreateUserChange
     */
    protected function getUpdateUserPasswordChange(User $user)
    {
        return new UpdateUserPasswordChange(
            $user->getUuid(),
            new PasswordHash('$2y$12$pILMfEPV3iFTY3aZVmUYtOCU6kTHHwNSu41gGDRP1hyMamBbXPD8G')
        );
    }

    /**
     * @return User
     */
    protected function createUser()
    {
        return User::create(
            'de305d54-75b4-431b-adb2-eb6b9e546013',
            'SomeName',
            'some@email.com',
            'LengthyPassword',
            (new RoleFactory())->createRole(1, 'Role_Maintenance', 8191)
        );
    }
}
