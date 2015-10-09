<?php
namespace kennysLabs\LusoExpress\Domain\User\Tests\Model;

use kennysLabs\LusoExpress\Domain\User\Model\Password;
use kennysLabs\LusoExpress\Domain\User\Model\PasswordHash;
use kennysLabs\LusoExpress\Domain\Shared\Tests\UnitTestCase;

/**
 * Class PasswordTest
 */
class PasswordTest extends UnitTestCase
{
    /**
     * @test
     */
    public function passwordRetrievesProperHash()
    {
        $passwordString = 'ThisIsSomePasswordWord';

        $password = new Password($passwordString);

        $this->assertInstanceOf(
            PasswordHash::class,
            $password->toPasswordHash()
        );

        $this->assertEquals($passwordString, $password->toString());

        $this->assertTrue(
            password_verify($passwordString, $password->toPasswordHash()->toString())
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function toShortPasswordThrowsException()
    {
        new Password('toShort');
    }
}
