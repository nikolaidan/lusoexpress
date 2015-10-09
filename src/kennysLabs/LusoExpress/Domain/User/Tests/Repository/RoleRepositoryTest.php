<?php
namespace kennysLabs\LusoExpress\Domain\User\Tests\Repository;

use kennysLabs\LusoExpress\Domain\User\Factory\RoleFactory;
use kennysLabs\LusoExpress\Domain\User\Model\RoleId;
use kennysLabs\LusoExpress\Domain\User\Repository\RoleRepository;
use kennysLabs\LusoExpress\Domain\Shared\Change\ChangeSet;
use kennysLabs\LusoExpress\Domain\Shared\Exception\MethodNotImplementedDomainException;
use kennysLabs\LusoExpress\Domain\Shared\Tests\UnitTestCase;

/**
 * Class RoleRepositoryTest
 */
final class RoleRepositoryTest extends UnitTestCase
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->roleRepository = new RoleRepository($this->getRoleArray(), new RoleFactory());
    }

    /**
     * @test
     */
    public function retrieveRolesSuccessfullyById()
    {
        $role = $this->roleRepository->findById(new RoleId(20));

        static::assertEquals(20, $role->getId()->toInteger());
        static::assertEquals('User_Maintenance', $role->getLabel()->toString());
    }

    /**
     * @test
     */
    public function retrieveRolesSuccessfullyByLabel()
    {
        $role = $this->roleRepository->findByLabel('User_Maintenance');

        static::assertEquals(20, $role->getId()->toInteger());
        static::assertEquals('User_Maintenance', $role->getLabel()->toString());
    }

    /**
     * @test
     */
    public function nonExistingRolesReturnNull()
    {
        static::assertNull($this->roleRepository->findByLabel('No_Role'));
        static::assertNull($this->roleRepository->findById(new RoleId(1000)));
    }

    /**
     * @test
     */
    public function saveThrowsException()
    {
        $this->setExpectedException(MethodNotImplementedDomainException::class);

        $this->roleRepository->save(new ChangeSet());
    }

    /**
     * @test
     */
    public function getRolesLowerOrEqualThan()
    {
        $roles = $this->roleRepository->getRoleIdsByPermissionLowerOrEqualThan(3072);

        static::assertEquals([
            10,
            1,
            11,
            2,
        ], $roles);
    }

    /**
     * @return array
     */
    private function getRoleArray()
    {
        return [
            'User_Maintenance' => ['id' => 20, 'permission' => 4096],
            'User_Administrator' => ['id' => 10, 'permission' => 2048],
            'User_Seller' => ['id' => 1, 'permission' => 1024],
            'User_Composed_Maintenance' => ['id' => 21, 'permission' => 7168],
            'User_Composed_Administrator' => ['id' => 11, 'permission' => 3072],
            'User_Composed_Seller' => ['id' => 2, 'permission' => 1024],
        ];
    }
}
