<?php
namespace kennysLabs\LusoExpress\Domain\User\Tests\Service;

use kennysLabs\LusoExpress\Domain\User\Factory\RoleFactory;
use kennysLabs\LusoExpress\Domain\User\Model\Role;
use kennysLabs\LusoExpress\Domain\User\Repository\RoleRepository;
use kennysLabs\LusoExpress\Domain\User\Service\RoleService;
use kennysLabs\LusoExpress\Domain\Shared\Tests\UnitTestCase;

/**
 * Class RoleServiceTest
 */
final class RoleServiceTest extends UnitTestCase
{
    /**
     * @test
     */
    public function roleServiceReturnsEntityById()
    {
        $this->assertInstanceOf(
            Role::class,
            $this->getRoleService()->getRoleById(1)
        );
    }

    /**
     * @test
     */
    public function roleServiceReturnsEntityByLabel()
    {
        $this->assertInstanceOf(
            Role::class,
            $this->getRoleService()->getRoleByLabel('User_Maintenance')
        );
    }

    /**
     * @test
     */
    public function roleServiceVerifiesRolePermission()
    {
        $role = (new RoleFactory())->createRole(1, 'Role_Maintenance', 8191);

        $this->assertTrue(
            $this->getRoleService()->hasRole(4096, $role)
        );

        $this->assertTrue(
            $this->getRoleService()->hasRole(2048, $role)
        );

        $this->assertFalse(
            $this->getRoleService()->hasRole(8192, $role)
        );
    }

    /**
     * @return RoleService
     */
    protected function getRoleService()
    {
        $roleRepository = new RoleRepository(
            [
                'User_Maintenance' => ['id' => 1, 'permission' => 8191],
                'User_Administrator' => ['id' => 2, 'permission' => 4095],
                'User_Seller' => ['id' => 3, 'permission' => 2047],
            ],
            new RoleFactory()
        );

        return new RoleService($roleRepository);
    }
}
