<?php
namespace kennysLabs\LusoExpress\Application\UserModule\Repository;

use kennysLabs\CommonLibrary\ORM\EntityRepositoryInterface;
use kennysLabs\LusoExpress\Infrastructure\Entity\Users as EntityUser;
use kennysLabs\CommonLibrary\ORM\EntityInterface;

class UserEntityRepository implements EntityRepositoryInterface
{
    private $pdo;

    /**
     * @param \FluentPDO $pdo
     */
    public function __construct(\FluentPDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $uuid
     * @return boolean|EntityInterface
     */
    public function findOneByUuid($uuid)
    {
        $userData = $this->pdo->from(EntityUser::ENTITY_NAME)->where('uuid = ?', $uuid)->fetch();

        if(!empty($userData)) {
            return EntityUser::createEntityFromArray($userData);
        }

        return false;
    }

    /**
     * @param string $email
     * @return boolean|EntityInterface
     */
    public function findOneByEmail($email)
    {
        $userData = $this->pdo->from(EntityUser::ENTITY_NAME)->where('email = ?', $email)->fetch();

        if(!empty($userData)) {
            return EntityUser::createEntityFromArray($userData);
        }

        return false;
    }

    /**
     * @param array $allowedRoleIds
     * @return int
     */
    public function getUsersCount($allowedRoleIds = []) {
        if (!empty($allowedRoleIds)) {
            return $this->pdo->count(EntityUser::ENTITY_NAME)->where('role_id IN (?)', implode(',', $allowedRoleIds))->fetch();
        } else
        {
            return $this->pdo->count(EntityUser::ENTITY_NAME)->fetch();
        }
    }

}