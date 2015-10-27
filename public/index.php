<?php

require_once(__DIR__ . '/../application/bootstrap.php');


use kennysLabs\CommonLibrary\ORM\EntityGenerator;
use kennysLabs\LusoExpress\Application;

// This will generate DB table entity files every time for testing purposes...
if(Application::getInstance()->getConfig()->{'main_section'}['TEST_MODE'] == 'true') {
    EntityGenerator::getInstance(Application::getInstance()->getPdo(), Application::getInstance()->getConfig())->generateEntityFile();
}

Application::getInstance()->run();
