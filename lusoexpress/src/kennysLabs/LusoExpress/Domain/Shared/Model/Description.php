<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Model;

/**
 * Class Description
 */
class Description
{
    /**
     * @var string $description
     */
    private $description;

    /**
     * @param string $description
     */
    public function __construct($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->description;
    }
}
