<?php
namespace kennysLabs\LusoExpress\Domain\User\Query;

use kennysLabs\LusoExpress\Domain\Shared\Query\QueryInterface;

/**
 * Class UserFind
 */
final class UserFind implements QueryInterface
{
    /**
     * @var null|string
     */
    private $uuid;

    /**
     * @var null|string
     */
    protected $email;

    /**
     * @param null|string $uuid
     * @param null|string $email
     */
    public function __construct($uuid = null, $email = null)
    {
        $this->uuid = $uuid;
        $this->email = $email;
    }

    /**
     * @return null|string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @return bool
     */
    public function hasUuid()
    {
        return ($this->uuid !== null);
    }

    /**
     * @return null|string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return bool
     */
    public function hasEmail()
    {
        return ($this->email !== null);
    }
}
