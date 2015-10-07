<?php
namespace kennysLabs\LusoExpress\Domain\User\Repository;

use kennysLabs\LusoExpress\Domain\User\Exception\UserAlreadyExistException;
use kennysLabs\LusoExpress\Domain\User\Model\User;
use kennysLabs\LusoExpress\Domain\User\Model\UserName;
use kennysLabs\LusoExpress\Domain\User\Model\UserEmail;
use kennysLabs\LusoExpress\Domain\User\Model\UserUuid;
use kennysLabs\LusoExpress\Domain\User\Model\UserActive;
use kennysLabs\LusoExpress\Domain\User\Model\PasswordHash;
use kennysLabs\LusoExpress\Domain\User\Query\UserList;
use kennysLabs\LusoExpress\Domain\Shared\Model\UniqueIdentifierInterface;
use kennysLabs\LusoExpress\Domain\User\Change\CreateUserChange;
use kennysLabs\LusoExpress\Domain\User\Change\UpdateUserChange;
use kennysLabs\LusoExpress\Domain\Shared\Repository\HasRepositorySaveTrait;
use kennysLabs\LusoExpress\Domain\Shared\Model\UuidGenerator;

use kennysLabs\LusoExpress\Domain\User\Factory\UserFactory;

use kennysLabs\CommonLibrary\ORM\EntityManagerInterface;
use kennysLabs\CommonLibrary\ORM\EntityRepositoryInterface;

use kennysLabs\LusoExpress\Infrastructure\Entity\Users as EntityUser;

/**
 * Interface UserRepositoryInterface
 */
class UserRepository implements UserRepositoryInterface
{
    use HasRepositorySaveTrait;

    /** @var  EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var UuidGenerator $uuidGenerator */
    private $uuidGenerator;

    /** @var UserFactory $userFactory */
    private $userFactory;

    /** @var RoleRepositoryInterface $roleRepository */
    private $roleRepository;

    /** @var EntityRepositoryInterface $pdo */
    protected $userRepository;

    public function __construct(EntityRepositoryInterface $userRepository, EntityManagerInterface $entityManager, UserFactory $userFactory, RoleRepositoryInterface $roleRepository) {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;

        $this->roleRepository = $roleRepository;
        $this->userFactory = $userFactory;

        $this->uuidGenerator = new UuidGenerator();
    }

    /**
     * @param UserList $userList
     *
     * @return User[]
     */
    public function findBy(UserList $userList) {
        /*
        $pagination = $userList->getPagination();
        $sorting = $userList->getSorting();
        */

        // TODO!
    }

    /**
     * @param UniqueIdentifierInterface $id
     * @return boolean|User
     */
    public function findById(UniqueIdentifierInterface $id)
    {
        if ($userEntity = $this->userRepository->findOneByUuid($id->toString())) {
            return $this->transformPDOEntityToUser($userEntity);
        }

        return false;
    }

    /**
     * @param UserEmail $email
     *
     * @return User|null
     */
    public function findByEmail(UserEmail $email) {
        if ($userEntity = $this->userRepository->findOneByEmail($email->toString())) {
            return $this->transformPDOEntityToUser($userEntity);
        }

        return false;
    }

    /**
     * @param UserList $userList
     * @return int
     */
    public function getUsersCount(UserList $userList) {
        return $this->userRepository->getUsersCount($userList->getAllowedRoleIds());
    }

    /**
     * @param CreateUserChange $change
     * @throws UserAlreadyExistException
     */
    protected function handleCreateUserChange(CreateUserChange $change)
    {
        $usersEntity = new EntityUser();
        $usersEntity->setUuid($change->getUuid()->toString());
        $usersEntity->setName($change->getName()->toString());
        $usersEntity->setEmail($change->getEmail()->toString());
        $usersEntity->setPasswordHash($change->getPassword()->toPasswordHash()->toString());
        $usersEntity->setActive($change->getActive()->toBoolean());
        $usersEntity->setRole($change->getRole()->getId()->toInteger());

        try {
            $this->entityManager->persist($usersEntity, EntityManagerInterface::TYPE_CREATE_ONLY);
        } catch (UniqueConstraintViolationException $e) {
            throw new UserAlreadyExistException();
        }
    }

    /**
     * @param UpdateUserChange $change
     * @throws UserNotFoundException
     */
    protected function handleUpdateUserChange(UpdateUserChange $change)
    {
        $usersEntity = new EntityUser();
        $usersEntity->setUuid($change->getUuid()->toString());
        $usersEntity->setName($change->getName()->toString());
        $usersEntity->setActive($change->getActive()->toBoolean());

        try {
            $this->entityManager->persist($usersEntity, EntityManagerInterface::TYPE_UPDATE_ONLY);
        } catch (UniqueConstraintViolationException $e) {
            throw new UserNotFoundException();
        }
    }

    /**
     * @param EntityUser $entityUser
     * @return User
     */
    protected function transformPDOEntityToUser(EntityUser $entityUser)
    {
        return $this->userFactory->createUserFromEntity($entityUser);
    }

}
