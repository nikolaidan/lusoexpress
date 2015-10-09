<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Model;

/**
 * Class Email
 */
class Email
{
    /**
     * @var string
     */
    private $email;

    /**
     * @param string $email
     */
    public function __construct($email)
    {
        $filteredEmail = filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        );

        if (false === $filteredEmail) {
            throw new \InvalidArgumentException("'" . $email . "' is an invalid email address.");
        }

        $this->email = $filteredEmail;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->email;
    }
}
