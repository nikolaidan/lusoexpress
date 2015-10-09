<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Tests\Model;

use kennysLabs\LusoExpress\Domain\User\Model\UserEmail;
use kennysLabs\LusoExpress\Domain\Shared\Tests\UnitTestCase;

/**
 * Class EmailTest
 */
final class EmailTest extends UnitTestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function invalidEmailThrowsException()
    {
        new UserEmail('thisIsNotAnEmail');
    }

    /**
     * @test
     */
    public function validEmailIsProperlySetAndRetrieved()
    {
        $emailString = 'account@domain.tld';

        $email = new UserEmail($emailString);

        $this->assertEquals($emailString, $email->toString());
    }
}
