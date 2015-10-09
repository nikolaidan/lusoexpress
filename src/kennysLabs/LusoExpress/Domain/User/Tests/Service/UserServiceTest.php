<?php
namespace kennysLabs\LusoExpress\Domain\User\Tests\Service;

use kennysLabs\LusoExpress\Domain\Shared\Model\UuidGenerator;
use kennysLabs\LusoExpress\Domain\User\Command\UserCreateCommand;
use kennysLabs\LusoExpress\Domain\User\Command\UserPasswordUpdateCommand;
use kennysLabs\LusoExpress\Domain\User\Command\UserUpdateCommand;
use kennysLabs\LusoExpress\Domain\User\Event\UserEventSubscriber;
use kennysLabs\LusoExpress\Domain\User\Factory\RoleFactory;
use kennysLabs\LusoExpress\Domain\User\Model\PasswordHash;
use kennysLabs\LusoExpress\Domain\User\Model\User;
use kennysLabs\LusoExpress\Domain\User\Model\UserActive;
use kennysLabs\LusoExpress\Domain\User\Model\UserEmail;
use kennysLabs\LusoExpress\Domain\User\Model\UserName;
use kennysLabs\LusoExpress\Domain\User\Model\UserUuid;
use kennysLabs\LusoExpress\Domain\User\Repository\RoleRepositoryInterface;
use kennysLabs\LusoExpress\Domain\User\Service\UserService;
use kennysLabs\LusoExpress\Domain\Shared\Event\SimpleEventBus;
use kennysLabs\LusoExpress\Domain\Shared\Model\UuidGeneratorInterface;
use kennysLabs\LusoExpress\Domain\Shared\Repository\RepositoryInterface;
use kennysLabs\LusoExpress\Domain\Shared\Tests\UnitTestCase;
use kennysLabs\LusoExpress\Domain\Shared\UnitOfWork\SimpleUnitOfWork;
use kennysLabs\LusoExpress\Domain\Shared\UnitOfWork\UnitOfWorkInterface;

/**
 * Class UserServiceTest
 */
final class UserServiceTest extends UnitTestCase
{
    /**
     * @test
     */
    public function userServiceCreateIsSuccessful()
    {
        $unitOfWorkMock = $this->getUnitOfWorkMock();
        $roleRepositoryMock = $this->getRoleRepositoryMock();
        $uuidGenerator = new UuidGenerator();

        $unitOfWorkMock
            ->expects(static::once())
            ->method('add');

        $unitOfWorkMock
            ->expects(static::once())
            ->method('commit');

        $roleRepositoryMock
            ->expects(static::once())
            ->method('findById')
            ->willReturn(
                (new RoleFactory())->createRole(3, 'User_seller', 1024)
            );

        /** @var UnitOfWorkInterface $unitOfWorkMock */
        /** @var RoleRepositoryInterface $roleRepositoryMock */
        $userService = new UserService(
            $unitOfWorkMock,
            $roleRepositoryMock,
            $uuidGenerator
        );

        $userService->createUser($this->getUserCreateCommand());
    }

    /**
     * @test
     */
    public function userServiceCreatePublishesEvent()
    {
        $repositoryMock = $this->getUserRepositoryMock();
        $roleRepositoryMock = $this->getRoleRepositoryMock();
        $uuidGeneratorMock = $this->getUuidGeneratorMock();

        $repositoryMock
            ->expects(static::once())
            ->method('save');

        $roleRepositoryMock
            ->expects(static::once())
            ->method('findById')
            ->willReturn(
                (new RoleFactory())->createRole(3, 'User_Seller', 2047)
            );

        $uuidGeneratorMock->expects(static::once())
            ->method('generate')
            ->willReturn('de305d54-75b4-431b-adb2-eb6b9e546013');

        $userEventSubscriber = new UserEventSubscriber();

        $eventBus = new SimpleEventBus();
        $eventBus->register($userEventSubscriber);

        /** @var RepositoryInterface $repositoryMock */
        $unitOfWork = new SimpleUnitOfWork(
            $repositoryMock,
            $eventBus
        );

        /** @var UuidGeneratorInterface $uuidGeneratorMock */
        /** @var RoleRepositoryInterface $roleRepositoryMock */
        $userService = new UserService(
            $unitOfWork,
            $roleRepositoryMock,
            $uuidGeneratorMock
        );

        $userService->createUser($this->getUserCreateCommand());

        static::assertEquals(
            [
                '0' =>
                    ['user.create' =>
                        [
                            'uuid' => 'de305d54-75b4-431b-adb2-eb6b9e546013',
                            'email' => 'valid@email.com',
                            'name' => 'A name',
                    ]
                ],
            ],
            $userEventSubscriber->getNotifications()
        );
    }

    /**
     * @test
     */
    public function userServiceUpdateIsSuccessful()
    {
        $unitOfWorkMock = $this->getUnitOfWorkMock();
        $roleRepositoryMock = $this->getRoleRepositoryMock();
        $uuidGeneratorMock = $this->getUuidGeneratorMock();

        $unitOfWorkMock
            ->expects(static::once())
            ->method('commit');

        $unitOfWorkMock
            ->expects(static::once())
            ->method('loadById')
            ->willReturn($this->getUserForRepositoryMock());

        /** @var UnitOfWorkInterface $unitOfWorkMock */
        /** @var RoleRepositoryInterface $roleRepositoryMock */
        $userService = new UserService(
            $unitOfWorkMock,
            $roleRepositoryMock,
            $uuidGeneratorMock
        );

        $userService->updateUser($this->getUserUpdateCommand());
    }

    /**
     * @test
     */
    public function userServiceUpdatePasswordIsSuccessful()
    {
        $unitOfWorkMock = $this->getUnitOfWorkMock();
        $roleRepositoryMock = $this->getRoleRepositoryMock();
        $uuidGeneratorMock = $this->getUuidGeneratorMock();

        $unitOfWorkMock
            ->expects(static::once())
            ->method('commit');

        $unitOfWorkMock
            ->expects(static::once())
            ->method('loadById')
            ->willReturn($this->getUserForRepositoryMock());

        /** @var UnitOfWorkInterface $unitOfWorkMock */
        /** @var RoleRepositoryInterface $roleRepositoryMock */
        $userService = new UserService(
            $unitOfWorkMock,
            $roleRepositoryMock,
            $uuidGeneratorMock
        );

        $userService->updateUserPassword($this->getUserUpdatePasswordCommand());
    }

    /**
     * @test
     */
    public function userServiceUpdatePublishesEvent()
    {
        $repositoryMock = $this->getUserRepositoryMock();
        $roleRepositoryMock = $this->getRoleRepositoryMock();
        $uuidGeneratorMock = $this->getUuidGeneratorMock();

        $repositoryMock
            ->expects(static::once())
            ->method('findById')
            ->willReturn($this->getUserForRepositoryMock());

        $userEventSubscriber = new UserEventSubscriber();

        $eventBus = new SimpleEventBus();
        $eventBus->register($userEventSubscriber);

        /** @var RepositoryInterface $repositoryMock */
        $unitOfWork = new SimpleUnitOfWork(
            $repositoryMock,
            $eventBus
        );

        /** @var UuidGeneratorInterface $uuidGeneratorMock */
        /** @var RoleRepositoryInterface $roleRepositoryMock */
        $userService = new UserService(
            $unitOfWork,
            $roleRepositoryMock,
            $uuidGeneratorMock
        );

        $userService->updateUser($this->getUserUpdateCommand());

        static::assertEquals(
            ['0' =>
                ['user.update' =>
                    ['uuid' => 'de305d54-75b4-431b-adb2-eb6b9e546013']
                ]
            ],
            $userEventSubscriber->getNotifications()
        );
    }

    /**
     * @test
     */
    public function userServicePasswordUpdatePublishesEvent()
    {
        $repositoryMock = $this->getUserRepositoryMock();
        $roleRepositoryMock = $this->getRoleRepositoryMock();
        $uuidGeneratorMock = $this->getUuidGeneratorMock();

        $repositoryMock
            ->expects(static::once())
            ->method('findById')
            ->willReturn(static::getUserForRepositoryMock());

        $userEventSubscriber = new UserEventSubscriber();

        $eventBus = new SimpleEventBus();
        $eventBus->register($userEventSubscriber);

        /** @var RepositoryInterface $repositoryMock */
        $unitOfWork = new SimpleUnitOfWork(
            $repositoryMock,
            $eventBus
        );

        /** @var UuidGeneratorInterface $uuidGeneratorMock */
        /** @var RoleRepositoryInterface $roleRepositoryMock */
        $userService = new UserService(
            $unitOfWork,
            $roleRepositoryMock,
            $uuidGeneratorMock
        );

        $userService->updateUserPassword($this->getUserUpdatePasswordCommand());

        static::assertEquals(
            ['0' =>
                ['user.password.update' =>
                    ['uuid' => 'de305d54-75b4-431b-adb2-eb6b9e546013']
                ]
            ],
            $userEventSubscriber->getNotifications()
        );
    }

    /**
     * @return User
     */
    protected function getUserForRepositoryMock()
    {
        return new User(
            new UserUuid('de305d54-75b4-431b-adb2-eb6b9e546013'),
            new UserName('Some Other Name'),
            new UserEmail('some.other@email.com'),
            new PasswordHash('blabala1'),
            new UserActive(true),
            (new RoleFactory())->createRole(4, 'User_Maintenance', 7168)
        );
    }

    /**
     * @return UserCreateCommand
     */
    protected function getUserCreateCommand()
    {
        return new UserCreateCommand(
            'A name',
            'valid@email.com',
            'SomePassword',
            1
        );
    }

    /**
     * @return UserUpdateCommand
     */
    protected function getUserUpdateCommand()
    {
        return new UserUpdateCommand(
            'de305d54-75b4-431b-adb2-eb6b9e546013',
            'A new name',
            false
        );
    }

    /**
     * @return UserPasswordUpdateCommand
     */
    protected function getUserUpdatePasswordCommand()
    {
        return new UserPasswordUpdateCommand(
            'de305d54-75b4-431b-adb2-eb6b9e546013',
            '$2y$12$pILMfEPV3iFTY3aZVmUYtOCU6kTHHwNSu41gGDRP1hyMamBbXPD8G'
        );
    }

    /**
     * @return RoleRepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getRoleRepositoryMock()
    {
        return $this->getMock(
            RoleRepositoryInterface::class,
            ['findById', 'findByLabel', 'findByPermission', 'getRoleIdsByPermissionLowerOrEqualThan', 'save']
        );
    }

    /**
     * @return RepositoryInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getUserRepositoryMock()
    {
        return $this->getMock(
            RepositoryInterface::class,
            ['findById', 'save']
        );
    }
}
