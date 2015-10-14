<?php

namespace kennysLabs\CommonLibrary\ORM;

interface EntityRepositoryInterface
{
    public function __construct(\FluentPDO $pdo);

    /**
     * @param string $uuid
     * @return boolean|EntityInterface
     */
    public function findOneByUuid($uuid);
}