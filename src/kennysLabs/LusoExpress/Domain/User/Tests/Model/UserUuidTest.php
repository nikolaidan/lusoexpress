<?php
namespace kennysLabs\LusoExpress\Domain\User\Tests\Model;

use kennysLabs\LusoExpress\Domain\User\Model\UserUuid;
use kennysLabs\LusoExpress\Domain\Shared\Tests\UnitTestCase;

/**
 * Class UserUuidTest
 */
final class UserUuidTest extends UnitTestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function invalidIdThrowsException()
    {
        new UserUuid('asdasda-faads');
    }

    /**
     * @test
     */
    public function createdIdWillProperlyTranslateTypes()
    {
        $userUuid = new UserUuid('de305d54-75b4-431b-adb2-eb6b9e546013');

        static::assertInternalType('string', $userUuid->toString());
    }
}
