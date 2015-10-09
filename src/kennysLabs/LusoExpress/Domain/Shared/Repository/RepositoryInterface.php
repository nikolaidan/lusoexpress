<?php
namespace kennysLabs\LusoExpress\Domain\Shared\Repository;

use kennysLabs\LusoExpress\Domain\Shared\Change\ChangeSet;
use kennysLabs\LusoExpress\Domain\Shared\Exception\DomainExceptionInterface;
use kennysLabs\LusoExpress\Domain\Shared\Model\UniqueIdentifierInterface;
use kennysLabs\LusoExpress\Domain\Shared\Model\EntityInterface;

/**
 * Interface Repository
 */
interface RepositoryInterface
{
    /**
     * @param ChangeSet $changeSet
     *
     * @throws DomainExceptionInterface
     *
     * @return null
     */
    public function save(ChangeSet $changeSet);

    /**
     * @param UniqueIdentifierInterface $id
     *
     * @return null|EntityInterface
     */
    public function findById(UniqueIdentifierInterface $id);
}
