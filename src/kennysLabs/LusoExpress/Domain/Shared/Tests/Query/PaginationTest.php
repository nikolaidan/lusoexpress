<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Tests\Model;

use kennysLabs\LusoExpress\Domain\Shared\Query\Pagination;
use kennysLabs\LusoExpress\Domain\Shared\Tests\UnitTestCase;

/**
 * Class PaginationTest
 */
class PaginationTest extends UnitTestCase
{
    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function expectExceptionOnInvalidSetTotalCount()
    {
        (new Pagination(20, 10))->setTotalCount(2);
    }
}
