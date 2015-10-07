<?php
namespace kennysLabs\LusoExpress\Domain\User\Command;

use kennysLabs\LusoExpress\Domain\Shared\Command\CommandInterface;

/**
 * Class UserCreateCommand
 */
class UserCreateCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var int
     */
    private $role;

    /**
     * @var string
     */
    private $password;

    /**
     * @param string $name
     * @param string $password
     * @param string $email
     * @param int $role
     */
    public function __construct($name, $email, $password, $role)
    {
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
