<?php
namespace kennysLabs\LusoExpress\Domain\User\Tests\Factory;

use kennysLabs\LusoExpress\Domain\User\Factory\RoleFactory;
use kennysLabs\LusoExpress\Domain\User\Model\Role;
use kennysLabs\LusoExpress\Domain\Shared\Tests\UnitTestCase;

/**
 * Class RoleFactoryTest
 */
class RoleFactoryTest extends UnitTestCase
{
    /**
     * @test
     */
    public function shouldCreateRole()
    {
        $role = (new RoleFactory())->createRole(1, 'my_role', 1024);

        $this->assertInstanceOf(
            Role::class,
            $role
        );
        $this->assertEquals(1, $role->getId()->toInteger());
        $this->assertEquals('my_role', $role->getLabel()->toString());
        $this->assertEquals(1024, $role->getPermission()->toInteger());
    }
}
