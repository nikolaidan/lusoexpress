<?php
namespace kennysLabs\LusoExpress\Domain\User\Tests\Repository;

use kennysLabs\CommonLibrary\ORM\EntityManagerInterface;
use kennysLabs\LusoExpress\Domain\User\Change\CreateUserChange;
use kennysLabs\LusoExpress\Domain\User\Change\UpdateUserChange;
use kennysLabs\LusoExpress\Domain\User\Change\UpdateUserPasswordChange;
use kennysLabs\LusoExpress\Domain\User\Factory\RoleFactory;
use kennysLabs\LusoExpress\Domain\User\Factory\UserFactory;
use kennysLabs\LusoExpress\Domain\User\Model\Password;
use kennysLabs\LusoExpress\Domain\User\Model\PasswordHash;
use kennysLabs\LusoExpress\Domain\User\Model\User;
use kennysLabs\LusoExpress\Domain\User\Model\UserActive;
use kennysLabs\LusoExpress\Domain\User\Model\UserEmail;
use kennysLabs\LusoExpress\Domain\User\Model\UserName;
use kennysLabs\LusoExpress\Domain\User\Model\UserUuid;
use kennysLabs\LusoExpress\Domain\User\Repository\UserRepository;
use kennysLabs\LusoExpress\Domain\User\Repository\RoleRepository;
use kennysLabs\LusoExpress\Domain\Shared\Change\ChangeInterface;
use kennysLabs\LusoExpress\Domain\Shared\Change\ChangeSet;
use kennysLabs\LusoExpress\Domain\Shared\Exception\MethodNotImplementedDomainException;
use kennysLabs\LusoExpress\Domain\Shared\Tests\UnitTestCase;
use kennysLabs\LusoExpress\Infrastructure\Entity\Users as UserEntity;
use kennysLabs\LusoExpress\Application\UserModule\Repository\UserEntityRepository;

/**
 * Class UserRepositoryTest
 */
final class UserRepositoryTest extends UnitTestCase
{
    /**
     * @var UserFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    private $userFactoryMock;

    /**
     * @test
     */
    public function handleCreateChangesIsCalled()
    {
        $changeSet = new ChangeSet();
        $changeSet->addChange(
            new CreateUserChange(
                new UserUuid('32d1d1c5-62e7-4c78-8e99-786b60b0fb89'),
                new UserName('Some Name'),
                new UserEmail('some@email.com'),
                new Password('blabala123A'),
                new UserActive(true),
                (new RoleFactory())->createRole(1, 'Role_Maintenance', 8191)
            )
        );

        /** @var UserRepository|\PHPUnit_Framework_MockObject_MockObject $userRepo */
        $userRepo = $this->getMockBuilder(UserEntityRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findUser', 'findOneBy', 'findOneByUuid'])
            ->getMock();

        $entityManager = $this->getEntityManagerMock();
        $entityManager->expects(static::exactly(1))
            ->method('persist');

        $this->getUserRepository($userRepo, $entityManager)
            ->save($changeSet);
    }


    /**
     * @test
     */
    public function handleUpdatePasswordChangesIsCalled()
    {
        $updateUserUuid = '4b891f62-fead-4cf7-99cd-f10a72141bfb';

        $changeSet = new ChangeSet();
        $changeSet->addChange(
            new UpdateUserPasswordChange(
                new UserUuid($updateUserUuid),
                new PasswordHash('$2y$12$pILMfEPV3iFTY3aZVmUYtOCU6kTHHwNSu41gGDRP1hyMamBbXPD8G')
            )
        );

        /** @var UserRepository|\PHPUnit_Framework_MockObject_MockObject $userRepo */
        $userRepo = $this->getMockBuilder(UserEntityRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findUser', 'findOneByUuid'])
            ->getMock();

        $userRepo->expects(static::once())
            ->method('findOneByUuid')
            ->willReturn($this->getUsersForRepositoryMock()[0][0]);

        $entityManager = $this->getEntityManagerMock($userRepo);
        $entityManager->expects(static::exactly(1))
            ->method('persist');

        $this->getUserRepository($userRepo, $entityManager)
            ->save($changeSet);
    }

    /**
     * @test
     */
    public function handleNonExistingChangeThrowsException()
    {
        $this->setExpectedException(MethodNotImplementedDomainException::class);
        $changeSet = new ChangeSet();
        /** @var \PHPUnit_Framework_MockObject_MockObject $changeMock */
        $changeMock = $this->getMock(ChangeInterface::class, ['getChangeName']);

        $changeMock->expects(static::once())
            ->method('getChangeName')
            ->willReturn('user.NoChangeMethodWithThisName');

        /** @var ChangeInterface $changeMock */
        $changeSet->addChange($changeMock);

        /** @var UserRepository|\PHPUnit_Framework_MockObject_MockObject $userRepo */
        $userRepo = $this->getMockBuilder(UserEntityRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findUser', 'findOneBy'])
            ->getMock();

        $entityManager = $this->getEntityManagerMock($userRepo);

        $this->getUserRepository($userRepo, $entityManager)
            ->save($changeSet);
    }

    /**
     * @test
     */
    public function findByIdReturnsProperEntity()
    {
        /** @var UserRepository|\PHPUnit_Framework_MockObject_MockObject $userRepo */
        $userRepo = $this->getMockBuilder(UserEntityRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneByUuid'])
            ->getMock();
        $userRepo->expects(static::once())
            ->method('findOneByUuid')
            ->willReturn(
                $this->getUsersForRepositoryMock()[0][0]
            );

        $repository = $this->getUserRepository($userRepo, $this->getEntityManagerMock($userRepo), 1);

        static::assertInstanceOf(
            User::class,
            $repository->findById(
                new UserUuid('4b891f62-fead-4cf7-99cd-f10a72141bfb')
            )
        );
    }

    /**
     * @test
     */
    public function findByEmailReturnsProperEntity()
    {
        /** @var UserRepository|\PHPUnit_Framework_MockObject_MockObject $userRepo */
        $userRepo = $this->getMockBuilder(UserEntityRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneByEmail'])
            ->getMock();
        $userRepo->expects(static::once())
            ->method('findOneByEmail')
            ->willReturnCallback(function ($args) {
                foreach ($this->getUsersForRepositoryMock()[0] as $user) {
                    if ($user->getEmail() === $args) {
                        return $user;
                    }
                }

                return null;
            });

        $repository = $this->getUserRepository($userRepo, $this->getEntityManagerMock($userRepo), 1);

        static::assertInstanceOf(
            User::class,
            $repository->findByEmail(
                new UserEmail('some@email.com')
            )
        );
    }

    /**
     * @test
     */
    public function handleUpdateChangesIsCalled()
    {
        $updateUserUuid = '4b891f62-fead-4cf7-99cd-f10a72141bfb';

        $changeSet = new ChangeSet();
        $changeSet->addChange(
            new UpdateUserChange(
                new UserUuid($updateUserUuid),
                new UserName('Some New Name'),
                new UserActive(false)
            )
        );

        /** @var UserRepository|\PHPUnit_Framework_MockObject_MockObject $userRepo */
        $userRepo = $this->getMockBuilder(UserEntityRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findUser', 'findOneByUuid'])
            ->getMock();

        $userRepo->expects(static::once())
            ->method('findOneByUuid')
            ->willReturn($this->getUsersForRepositoryMock()[0][0]);

        $entityManager = $this->getEntityManagerMock($userRepo);
        $entityManager->expects(static::exactly(1))
            ->method('persist');

        $this->getUserRepository($userRepo, $entityManager)
            ->save($changeSet);
    }

    /**
     * @param $userRepo
     * @param EntityManagerInterface $entityManager
     * @param int $roleRepositoryCalls
     *
     * @return UserRepository
     */
    protected function getUserRepository($userRepo, $entityManager, $roleRepositoryCalls = 0)
    {
        $roleRepo = new RoleRepository(
            [
                'User_Maintenance' => ['id' => 1, 'permission' => 8191],
                'User_Administrator' => ['id' => 2, 'permission' => 4095],
                'User_Seller' => ['id' => 3, 'permission' => 2047],
            ],
            new RoleFactory()
        );

        $roleRepositoryMock = $this->getMockBuilder(RoleRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $roleRepositoryMock->expects(static::exactly($roleRepositoryCalls))
            ->method('findById')
            ->willReturn((new RoleFactory())->createRole(1, 'Role_Maintenance', 8191));

        $this->userFactoryMock = $this->getMockBuilder(UserFactory::class)
            ->setConstructorArgs(
                [
                    $roleRepositoryMock,
                ]
            )
            ->setMethods(null)
            ->getMock();

        $userRepository = new UserRepository(
            $userRepo,
            $entityManager,
            $this->userFactoryMock,
            $roleRepo
        );

        return $userRepository;
    }



    /**
     * @return UserEntity[][]
     */
    private function getUsersForRepositoryMock()
    {
        $user1 = new UserEntity();
        $user1->setRole(1)
            ->setEmail('some@email.com')
            ->setUuid('4b891f62-fead-4cf7-99cd-f10a72141bfb')
            ->setPassword('asdasdasdasd')
            ->setActive(true)
            ->setName('Some Name');

        $user2 = new UserEntity();
        $user2->setRole(1)
            ->setEmail('some.other@email.com')
            ->setUuid('5a3dde5e-4e1e-4a6a-a55d-f08cf3010b8a')
            ->setPasswordHash('asdasdasdasd')
            ->setActive(true)
            ->setName('Some Name');

        return [
            [
                $user1,
            ],
            [
                $user2,
            ],
        ];
    }
}
