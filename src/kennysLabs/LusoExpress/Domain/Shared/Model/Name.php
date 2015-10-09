<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Model;

/**
 * Class Name
 */
class Name
{
    /**
     * @var string $name
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        if (strlen($name) < 4) {
            throw new \InvalidArgumentException("'" . $name . "' is too short.");
        }

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->name;
    }
}
