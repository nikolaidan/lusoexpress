<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require __DIR__.'/../vendor/autoload.php';

define('ROOT_PATH', dirname(__FILE__) );

use kennysLabs\LusoExpress\Domain\User\Model\User;
use kennysLabs\LusoExpress\Domain\User\Model\UserEmail;
use kennysLabs\LusoExpress\Domain\User\Command\UserCreateCommand;
use kennysLabs\LusoExpress\Domain\User\Command\UserUpdateCommand;

use kennysLabs\CommonLibrary\ORM\EntityGenerator;
use kennysLabs\LusoExpress\Application;

// This will generate DB table entity files every time for testing purposes...
if(Application::getInstance()->getConfig()->{'main_section'}['TEST_MODE'] == 'true') {
    EntityGenerator::getInstance(Application::getInstance()->getPdo(), Application::getInstance()->getConfig())->generateEntityFile();
}

// Generate random email to avoid duplicates.
$randEmail = 'test.user.'.rand(1000, 9999).'@mailinator.com';

// Create a command for our service.. in this case create a user command
$userCreateCommand = new UserCreateCommand('Test User', $randEmail, 'some password ' . rand(1000, 9999), 1);

// Let's create a user...
Application::getInstance()->getUserService()->createUser($userCreateCommand);

// Now let's find him to change the status to active = 1

/** @var User $foundUser */
$foundUser = Application::getInstance()->getUserRepository()->findByEmail(new UserEmail($randEmail));
$userUpdateCommand = new UserUpdateCommand($foundUser->getUuid(), $foundUser->getUserName()->toString(), true);

// Let's update him
Application::getInstance()->getUserService()->updateUser($userUpdateCommand);

// Check our notifications from the subscriber..
var_dump(Application::getInstance()->getUserEventSubscriber()->getNotifications());

