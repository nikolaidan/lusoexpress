<?php
namespace kennysLabs\LusoExpress;

use kennysLabs\LusoExpress\Application\UserModule\Repository\UserEntityRepository;

use kennysLabs\LusoExpress\Domain\User\Event\UserEventSubscriber;
use kennysLabs\LusoExpress\Domain\User\Repository\UserRepository;
use kennysLabs\LusoExpress\Domain\User\Repository\RoleRepository;
use kennysLabs\LusoExpress\Domain\User\Service\UserService;
use kennysLabs\LusoExpress\Domain\User\Factory\RoleFactory;
use kennysLabs\LusoExpress\Domain\User\Factory\UserFactory;

use kennysLabs\LusoExpress\Domain\Shared\UnitOfWork\SimpleUnitOfWork;
use kennysLabs\LusoExpress\Domain\Shared\Model\UuidGenerator;
use kennysLabs\LusoExpress\Domain\Shared\Event\SimpleEventBus;

use kennysLabs\CommonLibrary\ConfigParser;
use kennysLabs\CommonLibrary\ApplicationManager\BaseApplication;
use kennysLabs\CommonLibrary\ORM\EntityManagerPDO;

class Application extends BaseApplication
{
    protected static $instance;

    private $entityManagerPDO;
    private $userEntityRepository;
    private $userEventSubscriber;
    private $simpleEventBus;
    private $roleRepository;
    private $userFactory;
    private $userRepository;
    private $unitOfWork;
    private $userService;

    /**
     * @inheritdoc
     */
    protected function __construct($ini = '', $namespace = '')
    {
        parent::__construct($ini, $namespace);

        // Our entity manager
        $this->getDi()->add('entityManagerPDO', new EntityManagerPDO($this->pdo));

        $this->getDi()->add('userEntityRepository', new UserEntityRepository($this->pdo));

        // Our event subscriber that received all the events he needs for the user
        $this->getDi()->add('userEventSubscriber', new UserEventSubscriber());

        // Our event bus
        $this->getDi()->add('simpleEventBus', new SimpleEventBus());

        // Simple dummy role repository for creating a dummy user
        $this->getDi()->add('roleRepository', new RoleRepository(array('admin' => ['id' => 1, 'permission' => 777]), new RoleFactory()));

        // User Factory
        $this->getDi()->add('userFactory', new UserFactory($this->getDi()->get('roleRepository')));

        // Our user repository that will work with user data
        $this->getDi()->add('userRepository', new UserRepository(
            $this->getDi()->get('userEntityRepository'),
            $this->getDi()->get('entityManagerPDO'),
            $this->getDi()->get('userFactory'),
            $this->getDi()->get('roleRepository')));

        // Unit of work.. basically the "worker". Uses our repository and our event bus
        $this->getDi()->add('unitOfWork', new SimpleUnitOfWork($this->getDi()->get('userRepository'),
            $this->getDi()->get('simpleEventBus')));

        // We register our event subscriber in our bus...
        $this->getDi()->get('simpleEventBus')->register($this->getDi()->get('userEventSubscriber'));

        // Create a user service that takes care of doing things
        $this->getDi()->add('userService', new UserService($this->getDi()->get('unitOfWork'),
            $this->getDi()->get('roleRepository'),
            new UuidGenerator()));

        $this->setGlobalTemplate('base.html.twig');

    }
}