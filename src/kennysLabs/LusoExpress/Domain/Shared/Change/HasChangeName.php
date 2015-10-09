<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Change;

trait HasChangeName
{
    /**
     * Returns a unique name for the Change class
     *
     * @return string
     */
    public function getChangeName()
    {
        $className = static::class;
        $changeName = substr($className, strrpos($className, '\\') + 1);

        return $changeName;
    }
}
