<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Model;

/**
 * Interface UuidGeneratorInterface
 */
interface UuidGeneratorInterface
{
    /**
     * @return string
     */
    public function generate();
}
