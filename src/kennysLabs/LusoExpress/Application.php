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

    protected function __construct($ini = '')
    {
        parent::__construct($ini);

        // Our entity manager
        $this->entityManagerPDO = new EntityManagerPDO($this->pdo);

        $this->userEntityRepository = new UserEntityRepository($this->pdo);

        // Our event subscriber that received all the events he needs for the user
        $this->userEventSubscriber = new UserEventSubscriber();

        // Our event bus
        $this->simpleEventBus = new SimpleEventBus();

        // Simple dummy role repository for creating a dummy user
        $this->roleRepository = new RoleRepository(array('admin' => ['id' => 1, 'permission' => 777]), new RoleFactory());

        // User Factory
        $this->userFactory = new UserFactory($this->roleRepository);

        // Our user repository that will work with user data
        $this->userRepository = new UserRepository($this->userEntityRepository, $this->entityManagerPDO, $this->userFactory, $this->roleRepository);

        // Unit of work.. basically the "worker". Uses our repository and our event bus
        $this->unitOfWork = new SimpleUnitOfWork($this->userRepository, $this->simpleEventBus);

        // We register our event subscriber in our bus...
        $this->simpleEventBus->register($this->userEventSubscriber);

        // Create a user service that takes care of doing things
        $this->userService = new UserService($this->unitOfWork, $this->roleRepository, new UuidGenerator());

    }

    /**
     * @return UserService
     */
    public function getUserService()
    {
        return $this->userService;
    }

    /**
     * @return UserRepository
     */
    public function getUserRepository()
    {
        return $this->userRepository;
    }

    /**
     * @return UserEventSubscriber
     */
    public function getUserEventSubscriber()
    {
        return $this->userEventSubscriber;
    }

    /**
     * @return ConfigParser
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return \FluentPDO
     */
    public function getPdo()
    {
        return $this->pdo;
    }
}