<?php
namespace kennysLabs\LusoExpress\Domain\User\Service;

use kennysLabs\LusoExpress\Domain\User\Command\UserCreateCommand;
use kennysLabs\LusoExpress\Domain\User\Command\UserPasswordUpdateCommand;
use kennysLabs\LusoExpress\Domain\User\Command\UserUpdateCommand;
use kennysLabs\LusoExpress\Domain\User\Event\UserExceptionEvent;
use kennysLabs\LusoExpress\Domain\User\Model\Role;
use kennysLabs\LusoExpress\Domain\User\Model\RoleId;
use kennysLabs\LusoExpress\Domain\User\Model\User;
use kennysLabs\LusoExpress\Domain\User\Model\UserUuid;
use kennysLabs\LusoExpress\Domain\User\Repository\RoleRepositoryInterface;
use kennysLabs\LusoExpress\Domain\Shared\Exception\DomainExceptionInterface;
use kennysLabs\LusoExpress\Domain\Shared\Model\UuidGeneratorInterface;
use kennysLabs\LusoExpress\Domain\Shared\UnitOfWork\UnitOfWorkInterface;

/**
 * Class UserService
 */
final class UserService
{
    /**
     * @var UnitOfWorkInterface
     */
    private $unitOfWork;

    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * @var UuidGeneratorInterface
     */
    private $uuidGenerator;

    /**
     * @param UnitOfWorkInterface $unitOfWork
     * @param RoleRepositoryInterface $roleRepository
     * @param UuidGeneratorInterface $uuidGenerator
     */
    public function __construct(
        UnitOfWorkInterface $unitOfWork,
        RoleRepositoryInterface $roleRepository,
        UuidGeneratorInterface $uuidGenerator
    ) {
        $this->unitOfWork = $unitOfWork;
        $this->roleRepository = $roleRepository;
        $this->uuidGenerator = $uuidGenerator;
    }

    /**
     * @param UserCreateCommand $create
     */
    public function createUser(UserCreateCommand $create)
    {
        try {
            $roleId = new RoleId($create->getRole());

            /** @var Role $role */
            $role = $this->roleRepository->findById($roleId);

            $user = User::create(
                $this->uuidGenerator->generate(),
                $create->getName(),
                $create->getEmail(),
                $create->getPassword(),
                $role
            );

            $this->unitOfWork->add($user);
            $this->unitOfWork->commit();
        } catch (DomainExceptionInterface $e) {
            $this->unitOfWork->handleException(new UserExceptionEvent($e));
        }
    }

    /**
     * @param UserUpdateCommand $update
     */
    public function updateUser(UserUpdateCommand $update)
    {
        try {
            /** @var User $user */
            $user = $this->unitOfWork->loadById(new UserUuid($update->getUuid()));
            $user->updateUser($update);
            $this->unitOfWork->commit();
        } catch (DomainExceptionInterface $e) {
            $this->unitOfWork->handleException(new UserExceptionEvent($e));
        }
    }

    /**
     * @param UserPasswordUpdateCommand $updatePassword
     */
    public function updateUserPassword(UserPasswordUpdateCommand $updatePassword)
    {
        try {
            /** @var User $user */
            $user = $this->unitOfWork->loadById(new UserUuid($updatePassword->getUuid()));
            $user->updateUserPassword($updatePassword);
            $this->unitOfWork->commit();
        } catch (DomainExceptionInterface $e) {
            $this->unitOfWork->handleException(new UserExceptionEvent($e));
        }
    }
}
