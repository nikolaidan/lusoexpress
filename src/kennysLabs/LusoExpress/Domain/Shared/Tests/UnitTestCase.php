<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Tests;

use kennysLabs\LusoExpress\Domain\Shared\Model\UuidGeneratorInterface;
use kennysLabs\LusoExpress\Domain\Shared\UnitOfWork\UnitOfWorkInterface;
use kennysLabs\CommonLibrary\ORM\EntityManagerPDO;

/**
 * Class UnitTestCase
 * Base class for SellerCenter tests
 */
abstract class UnitTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return EntityManagerPDO|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getEntityManagerMock()
    {
        $emMock = $this->getMock(
            EntityManagerPDO::class,
            ['persist'],
            [],
            '',
            false
        );
        $emMock->expects(static::any())
            ->method('persist')
            ->will(static::returnValue(null));

        return $emMock;
    }

    /**
     * @return UnitOfWorkInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getUnitOfWorkMock()
    {
        return $this->getMock(
            UnitOfWorkInterface::class,
            ['add', 'commit', 'loadById', 'findById', 'handleException']
        );
    }

    /**
     * @return UuidGeneratorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getUuidGeneratorMock()
    {
        return $this->getMock(
            UuidGeneratorInterface::class,
            ['generate']
        );
    }
}
