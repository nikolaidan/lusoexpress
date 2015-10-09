<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Model;

/**
 * Class Active
 */
class Active
{
    /**
     * @var bool
     */
    private $active;

    /**
     * @param bool $active
     */
    public function __construct($active)
    {
        $this->active = $active;
    }

    /**
     * @return bool
     */
    public function toBoolean()
    {
        return $this->active;
    }
}
