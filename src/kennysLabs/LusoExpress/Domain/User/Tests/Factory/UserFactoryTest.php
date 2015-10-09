<?php
namespace kennysLabs\LusoExpress\Domain\User\Tests\Factory;

use kennysLabs\LusoExpress\Domain\User\Factory\RoleFactory;
use kennysLabs\LusoExpress\Domain\User\Factory\UserFactory;
use kennysLabs\LusoExpress\Domain\User\Model\User;
use kennysLabs\LusoExpress\Domain\User\Repository\RoleRepository;
use kennysLabs\LusoExpress\Domain\Shared\Tests\UnitTestCase;
use kennysLabs\LusoExpress\Infrastructure\Entity\Users as EntityUser;

/**
 * Class UserFactoryTest
 */
class UserFactoryTest extends UnitTestCase
{
    /**
     * @test
     */
    public function shouldCreateUser()
    {
        /** @var RoleRepository|\PHPUnit_Framework_MockObject_MockObject $roleRepositoryMock */
        $roleRepositoryMock = $this->getMockBuilder(RoleRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $roleRepositoryMock->expects(static::once())
            ->method('findById')
            ->willReturn((new RoleFactory())->createRole(1, 'Role_Maintenance', 8191));

        $uuid = 'c2aa7add-7279-4859-9c3d-c0c340d3eed3';

        $entityUser = (new EntityUser())
            ->setUuid($uuid)
            ->setName('Test Name')
            ->setEmail('my@email.com')
            ->setRole(1)
            ->setActive(true);

        $user = (new UserFactory($roleRepositoryMock))->createUserFromEntity($entityUser);

        static::assertInstanceOf(
            User::class,
            $user
        );
        static::assertEquals($uuid, $user->getUuid()->toString());
    }
}
