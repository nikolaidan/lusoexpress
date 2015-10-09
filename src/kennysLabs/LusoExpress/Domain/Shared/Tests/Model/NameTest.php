<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Tests\Model;

use kennysLabs\LusoExpress\Domain\Shared\Model\Name;
use kennysLabs\LusoExpress\Domain\Shared\Tests\UnitTestCase;

/**
 * Class NameTest
 */
final class NameTest extends UnitTestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function nameThrowsExceptionIfToShort()
    {
        new Name('no');
    }

    /**
     * @test
     */
    public function nameWithMinimumLength()
    {
        $userName = new Name('Some Name Test');

        $this->assertInternalType('string', $userName->toString());
    }
}
