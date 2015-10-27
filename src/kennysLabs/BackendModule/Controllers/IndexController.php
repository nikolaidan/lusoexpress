<?php

namespace kennysLabs\BackendModule\Controllers;

use kennysLabs\CommonLibrary\ApplicationManager\BaseController;
use kennysLabs\LusoExpress\Domain\User\Model\User;
use kennysLabs\LusoExpress\Domain\User\Model\UserEmail;
use kennysLabs\LusoExpress\Domain\User\Command\UserCreateCommand;
use kennysLabs\LusoExpress\Domain\User\Command\UserUpdateCommand;


class IndexController extends BaseController
{
    public function indexAction()
    {
        // Disable view
        $this->toggleActionTemplate(false);
        $this->toggleControllerTemplate(false);

        // Generate random email to avoid duplicates.
        $randEmail = 'test.user.'.rand(1000, 9999).'@mailinator.com';

        // Create a command for our service.. in this case create a user command
        $userCreateCommand = new UserCreateCommand('Test User', $randEmail, 'some password ' . rand(1000, 9999), 1);

        // Let's create a user...
        $this->getApplication()->getDi()->get('userService')->createUser($userCreateCommand);

        // Now let's find him to change the status to active = 1

        /** @var User $foundUser */
        $foundUser = $this->getApplication()->getDi()->get('userRepository')->findByEmail(new UserEmail($randEmail));
        $userUpdateCommand = new UserUpdateCommand($foundUser->getUuid()->toString(), $foundUser->getUserName()->toString() . ' updated', true);

        // Let's update him
        $this->getApplication()->getDi()->get('userService')->updateUser($userUpdateCommand);

        // Check our notifications from the subscriber..
        var_dump($this->getApplication()->getDi()->get('userEventSubscriber')->getNotifications());
    }

    public function loginAction()
    {
    }

}