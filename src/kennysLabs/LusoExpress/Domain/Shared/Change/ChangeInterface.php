<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Change;

/**
 * Interface Change
 * Describes a change occurred in a model class after some command has been applied
 */
interface ChangeInterface
{
    /**
     * Returns a unique name for the Change class
     *
     * @return string
     */
    public function getChangeName();
}
