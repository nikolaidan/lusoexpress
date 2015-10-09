<?php
namespace kennysLabs\LusoExpress\Domain\User\Model;

/**
 * Class RoleLabel
 */
final class RoleLabel
{
    /**
     * @var string
     */
    private $label;

    /**
     * @param string $label
     */
    public function __construct($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->label;
    }
}
