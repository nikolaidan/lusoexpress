<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Model;

/**
 * Interface Entity
 */
interface EntityInterface
{
    /**
     * @return mixed
     */
    public function flushChanges();
}
